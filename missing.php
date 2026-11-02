<?php
require __DIR__ . '/config.php';
$f = isset($_GET['f']) ? basename((string)$_GET['f']) : '';
echo page_head('Brak pliku – ' . $f);
?>
<div class="wrap">
  <header class="top"><h1>Tego pliku jeszcze nie ma</h1>
    <p>Strona <code><?= h($f) ?></code> nie została dodana do portalu.</p></header>
  <p class="intro">Wgraj ją do folderu <code>owe2/</code> (nazwa pliku jak w <code>portal.json</code>) albo wróć do zakładki.</p>
  <p><a class="card" style="display:inline-block" href="index.php?tab=owe2">← Wróć do zakładki OWE II</a>
     <a class="card" style="display:inline-block" href="index.php">🏠 Strona główna</a></p>
</div>
</body></html>
