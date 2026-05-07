<?php

// Sobhan Haerizadeh
// https://sobhanhaerizadeh.com

// ── API Fetch with cURL ──
function fetchApi(string $url): ?array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error || !$response) return null;
    return json_decode($response, true);
}

$data = fetchApi("https://disease.sh/v3/covid-19/all");

// ── Fallback if API is unavailable ──
if (!$data) {
    $error = true;
} else {
    $error          = false;
    $totalCases     = $data['cases'];
    $todayDeaths    = $data['todayDeaths'];
    $todayRecovered = $data['todayRecovered'];
    $allDeaths      = $data['deaths'];
    $allRecovered   = $data['recovered'];
    $activeCases    = $data['active'];
    $critical       = $data['critical'];
    $population     = $data['population'];
    $updated        = $data['updated'];
    $lastUpdated    = date('M d, Y · H:i', $updated / 1000);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COVID-19 Tracker</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="wrapper">

    <?php if ($error): ?>

    <!-- Error -->
    <div class="error-box">
      <div class="error-icon">⚠️</div>
      <div class="error-title">API unavailable</div>
      <p>Could not connect to the disease.sh API. Please try again later.</p>
      <a href="" class="retry-btn">Reload page</a>
    </div>

    <?php else: ?>

    <!-- Header -->
    <header>
      <div class="eyebrow">Live Data</div>
      <h1>COVID-19 <em>Tracker</em></h1>
      <p class="subtitle">Worldwide real-time statistics — updated automatically.</p>
      <div class="last-updated">
        <span class="pulse-dot"></span>
        Last updated: <?php echo $lastUpdated; ?> UTC
      </div>
    </header>

    <!-- Main stat -->
    <div class="hero-stat">
      <div class="hero-label">Total infections worldwide</div>
      <div class="hero-number" data-target="<?php echo $totalCases; ?>">0</div>
    </div>

    <!-- Divider -->
    <div class="divider">
      <div class="divider-line"></div>
      <span class="divider-label">STATISTICS</span>
      <div class="divider-line"></div>
    </div>

    <!-- Grid -->
    <div class="stats-grid">

      <div class="stat-card stat-danger">
        <div class="card-top">
          <span class="card-label">Total Deaths</span>
          <span class="card-icon">💀</span>
        </div>
        <div class="card-number" data-target="<?php echo $allDeaths; ?>">0</div>
      </div>

      <div class="stat-card stat-success">
        <div class="card-top">
          <span class="card-label">Total Recovered</span>
          <span class="card-icon">💚</span>
        </div>
        <div class="card-number" data-target="<?php echo $allRecovered; ?>">0</div>
      </div>

      <div class="stat-card stat-warning">
        <div class="card-top">
          <span class="card-label">Active Cases</span>
          <span class="card-icon">🔴</span>
        </div>
        <div class="card-number" data-target="<?php echo $activeCases; ?>">0</div>
      </div>

      <div class="stat-card stat-neutral">
        <div class="card-top">
          <span class="card-label">World Population</span>
          <span class="card-icon">🌍</span>
        </div>
        <div class="card-number" data-target="<?php echo $population; ?>">0</div>
      </div>

    </div>

    <!-- Footer -->
    <footer>
    <div class="footer-left">
        <span class="footer-made">Coded by</span>
        <span class="footer-author">
        <a href="https://Sobhanhaerizadeh.de" target="_blank">Sobhan Haerizadeh</a>
        </span>
    </div>
    <div class="footer-right">
        <span class="footer-heart">
        Made with <span class="heart-icon">♥</span>
        </span>
        <div class="footer-dot"></div>
    </div>
    </footer>

    <script>
      const covidData = {
        totalCases:     <?php echo $totalCases; ?>,
        allDeaths:      <?php echo $allDeaths; ?>,
        allRecovered:   <?php echo $allRecovered; ?>,
        activeCases:    <?php echo $activeCases; ?>,
        critical:       <?php echo $critical; ?>,
        todayDeaths:    <?php echo $todayDeaths; ?>,
        todayRecovered: <?php echo $todayRecovered; ?>,
        population:     <?php echo $population; ?>
      };
    </script>
    <script src="js/script.js"></script>

    <?php endif; ?>

  </div>
</body>
</html>