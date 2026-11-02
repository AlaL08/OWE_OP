<?php
/**
 * config.php – wspólne funkcje portalu (obsługa PHP w jednym miejscu).
 * Dane o zakładkach i plikach są w portal.json – tam dopisujesz nowe strony.
 */
const BASE_DIR = __DIR__;

function load_data() {
    static $data = null;
    if ($data === null) {
        $raw = @file_get_contents(BASE_DIR . '/portal.json');
        $data = $raw ? json_decode($raw, true) : null;
        if (!is_array($data)) {
            $data = array('title' => 'Portal', 'tabs' => array('start' => array('label' => 'Start')), 'start' => array('cards' => array()));
        }
    }
    return $data;
}

function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Zwraca bezpieczną nazwę zakładki z adresu (?tab=...). */
function current_tab($tabs) {
    $t = isset($_GET['tab']) ? (string)$_GET['tab'] : 'start';
    return isset($tabs[$t]) ? $t : 'start';
}

function item_exists($dir, $file) {
    return is_file(BASE_DIR . '/' . $dir . '/' . $file);
}

function href_for($dir, $file) {
    return $dir . '/' . rawurlencode($file);
}

function render_tabs($tabs, $active) {
    $out = '<nav class="tabs" aria-label="Zakładki">';
    foreach ($tabs as $key => $tab) {
        $cls = ($key === $active) ? ' class="on"' : '';
        $out .= '<a' . $cls . ' href="index.php?tab=' . h($key) . '">' . h($tab['label']) . '</a>';
    }
    return $out . '</nav>';
}

function render_card($dir, $item) {
    $file = $item['file'];
    $ok = item_exists($dir, $file);
    $badge = isset($item['badge']) ? '<span class="badge">' . h($item['badge']) . '</span>' : '';
    $desc = isset($item['desc']) ? '<p>' . h($item['desc']) . '</p>' : '';
    if ($ok) {
        return '<a class="card" href="' . h(href_for($dir, $file)) . '">' . $badge . '<h3>' . h($item['title']) . '</h3>' . $desc . '</a>';
    }
    return '<a class="card missing" href="missing.php?f=' . rawurlencode($file) . '">' . $badge . '<span class="badge warn">brak pliku</span><h3>' . h($item['title']) . '</h3>' . $desc . '</a>';
}

function render_sections($dir, $sections) {
    $out = '';
    foreach ($sections as $sec) {
        $out .= '<section><h2>' . h($sec['title']) . '</h2><div class="grid">';
        foreach ($sec['items'] as $item) {
            $out .= render_card($dir, $item);
        }
        $out .= '</div></section>';
    }
    return $out;
}

function count_existing($dir, $sections) {
    $n = 0;
    foreach ($sections as $sec) {
        foreach ($sec['items'] as $item) {
            if (item_exists($dir, $item['file'])) { $n++; }
        }
    }
    return $n;
}

/** Wspólny nagłówek HTML + style (używany przez index.php i missing.php). */
function page_head($title) {
    return '<!DOCTYPE html><html lang="pl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>' . h($title) . '</title><link rel="stylesheet" href="portal.css"></head><body>';
}
