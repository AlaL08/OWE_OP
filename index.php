<?php
require __DIR__ . '/config.php';

$data   = load_data();
$tabs   = $data['tabs'];
$active = current_tab($tabs);

echo page_head(($tabs[$active]['label'] ?? 'Start') . ' – ' . $data['title']);
?>
<div class="wrap">
  <header class="top">
    <h1><?= h($data['title']) ?></h1>
    <p>Wiedza i zadania do olimpiad ekonomicznych – jedna strona główna, dwie zakładki.</p>
  </header>
  <?= render_tabs($tabs, $active) ?>

<?php if ($active === 'start'): ?>
  <p class="intro">Wybierz zakładkę. Dotychczasowa strona z wiedzą (dawny <code>index</code>) jest teraz podstroną w zakładce „Olimpiada Przedsiębiorczości”, a pliki OWE II – w zakładce „OWE II”.</p>
  <div class="big">
  <?php foreach ($data['start']['cards'] as $c): ?>
    <a class="card" href="index.php?tab=<?= h($c['tab']) ?>">
      <span class="badge">zakładka</span>
      <h3><?= h($c['title']) ?></h3>
      <p><?= h($c['desc']) ?></p>
      <?php if (isset($data[$c['tab']]['dir'], $data[$c['tab']]['sections'])): ?>
        <p style="margin-top:8px"><b><?= count_existing($data[$c['tab']]['dir'], $data[$c['tab']]['sections']) ?></b> stron w tej zakładce</p>
      <?php endif; ?>
    </a>
  <?php endforeach; ?>
  </div>

<?php elseif ($active === 'op'): $op = $data['op']; ?>
  <p class="intro"><?= h($op['intro']) ?></p>
  <section><h2>Wejście</h2><div class="grid">
    <?= render_card($op['dir'], $op['entry'] + array('badge' => 'start')) ?>
  </div></section>
  <?= render_sections($op['dir'], $op['sections']) ?>

<?php elseif ($active === 'owe2'): $owe = $data['owe2']; ?>
  <p class="intro"><?= h($owe['intro']) ?></p>
  <?= render_sections($owe['dir'], $owe['sections']) ?>
  <p class="note">Brakujące pliki (zaznaczone jako „brak pliku”) wgraj do folderu <code>owe2/</code> pod nazwą z <code>portal.json</code> – karta sama zacznie prowadzić do strony.</p>
<?php endif; ?>

  <p class="note">Portal działa na serwerze z PHP (np. <code>php -S localhost:8000</code> w tym folderze).</p>
</div>
</body></html>
