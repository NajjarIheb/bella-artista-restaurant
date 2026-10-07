<?php

if (!function_exists('analyticsStatCard')) {
    function analyticsStatCard($label, $value, $sub = null)
    {
        return '<div style="background: var(--bg-card); border: 1px solid var(--color-border); border-radius: 4px; padding: 1.5rem;">'
            . '<div style="font-size: 0.8rem; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">' . e($label) . '</div>'
            . '<div style="font-size: 1.7rem; font-weight: 700; color: var(--color-gold);">' . e($value) . '</div>'
            . ($sub ? '<div style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.4rem;">' . e($sub) . '</div>' : '')
            . '</div>';
    }
}

if (!function_exists('analyticsBarRow')) {
    function analyticsBarRow($label, $value, $max, $trailing = '')
    {
        $pct = $max > 0 ? round($value / $max * 100, 1) : 0;
        return '<div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 0.6rem;">'
            . '<span style="width: 110px; flex-shrink: 0; font-size: 0.9rem; color: var(--color-cream);">' . e($label) . '</span>'
            . '<div style="flex: 1; background: rgba(255,255,255,0.05); height: 18px; border-radius: 3px; overflow: hidden;">'
            . '<div style="width: ' . $pct . '%; height: 100%; background: var(--color-gold); border-radius: 3px;"></div>'
            . '</div>'
            . '<span style="width: 80px; text-align: right; font-size: 0.9rem; color: var(--color-text-muted); flex-shrink: 0;">' . e($trailing) . '</span>'
            . '</div>';
    }
}
