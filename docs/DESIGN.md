# KeFamily design system (v1.2)

## Direction
White-led Swiss editorial. The page is paper; structure comes from hairlines,
a 12-column grid and numbered sections, not from cards, glows or gradients.
KeFamily itself is ink on white (white on ink in dark mode). Brand colour is
used only where that brand is the subject: the rotator word, the index
number, a 2–3px rule, a dot, an icon tile, a hover bar.

## Tokens (assets/css/main.css `:root`)
| Group | Tokens |
|---|---|
| Colour | `--bg #fff`, `--bg-2 #f5f5f3`, `--text #0b0b0d`, `--text-2`, `--muted #5d5d67`, `--line`, `--line-2`, `--inv-bg/--inv-text` (inverted bands) |
| Brand (inline per context via `kf_brand_style()`) | `--c` colour, `--cl` light tint, `--ci` deep ink, `--c2` alt, `--g` rgb, `--con` text on colour, `--ct` mode-aware brand text |
| Type | Manrope 200–800 (Latin, Latin-ext, Cyrillic), Readex Pro (Arabic). Sizes `--fs-xs … --fs-mega` (fluid clamp) |
| Space | 4-pt scale `--s1 4px … --s10 128px`, `--section` fluid |
| Radius | `--radius 10px`, `--radius-lg 16px`, pills 999px |
| Motion | `--t-fast 120ms`, `--t-base 220ms`, `--t-slow 420ms`, one easing; all motion off under `prefers-reduced-motion` |
| Layers | `--z-nav 50`, `--z-menu 60`, `--z-dock 70`, `--z-skip 100` |

Brand colours: KePixel #2367F2 · KeMarq #8247DB · KeChat #25D366 · KeClinic #FACC15.
Text uses the ink shade in light mode (`--ci`) and the light tint in dark
mode (`--cl`) so brand-coloured text passes WCAG AA in both.

## Components
- `.shead` numbered section header (n / eyebrow / h2 / lead)
- `.cindex` company index rows (home)
- `.bento` + `.card__visual` product screens (always dark)
- `.beams` ecosystem diagram, `.steps`, `.facts`, `.values`, `.sectors`
- `.post-card`, `.filters`, `.pager`, `.prose`
- `.faq`, `.cta` (inverted), `.dock` (WhatsApp panel + meeting)
- `.book` booking flow (`.opt`, `.day`, `.slot`, `.book__card`)
- Buttons: `.btn` (ink), `.btn--line`, `.btn--inv`, `.btn--wa`; inside a brand
  context `.btn` fills with the brand colour.

## Rules
- One H1 per page, no heading skips, max line length ~60ch for body.
- No decorative motion that loops on the page except the product screens
  and the ecosystem beams; reveals are opacity + 14px rise only.
- Touch targets ≥ 44px; focus ring 2px `--focus` on every control.
- RTL: logical properties everywhere; Latin names inside Arabic keep RTL
  alignment.
