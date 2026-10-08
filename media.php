<?php
/**
 * media.php — Media coverage page.
 */

declare(strict_types=1);

require __DIR__ . '/config.php';
require __DIR__ . '/includes/bootstrap.php';

security_headers();

$currentPageFile = 'media.php';

require __DIR__ . '/includes/media-data.php';
require __DIR__ . '/includes/nav.php';

$bodyClass       = 'page-media';
$transparent     = false;
$showModal       = false;
$pageTitle       = 'Media & Press | ' . SITE_NAME;
$pageDesc        = 'Media coverage and articles featuring Adv. Javed Pashu Sayyed.';
$canonical       = SITE_URL . '/media.php';

require __DIR__ . '/includes/head.php';
require __DIR__ . '/includes/header.php';

$sources = [];
$topics = [];
foreach ($mediaItems as $m) {
    $srcName = (string) ($m["source"] ?? "Media");
    $sources[$srcName] = $sources[$srcName] ?? (string) $m["url"];
    if (!empty($m["topic"])) {
        $topics[(string) $m["topic"]] = true;
    }
}
?>
<style>
.media-hero { padding: calc(var(--header-h) + clamp(2.5rem, 6vw, 4.5rem)) 0 clamp(2rem, 4vw, 3rem); border-bottom: 1px solid var(--line); background: linear-gradient(180deg, var(--paper-2), var(--paper)); }
.media-hero h1 { color: var(--ink); font-size: var(--fs-h1); margin-top: .75rem; line-height: 1.08; }
.media-hero .lead { max-width: 620px; margin-top: 1rem; font-size: var(--fs-md); line-height: 1.6; color: var(--muted); }
.media-hero .mhead__stats { list-style: none; padding: 0; margin: 2rem 0 0; display: flex; flex-wrap: wrap; gap: 1rem 3rem; color: var(--muted); font-size: var(--fs-sm); }
.media-hero .mhead__stats li { display: flex; flex-direction: column; gap: .15rem; border-left: 2px solid var(--gold-line); padding-left: 1rem; }
.media-hero .mhead__stats strong { color: var(--gold); font-family: var(--serif); font-size: 1.75rem; font-weight: 600; line-height: 1.1; }

.mfeat { padding: 1.25rem 0; border-bottom: 1px solid var(--line); background: var(--surface-2); }
.mfeat .container { display: flex; align-items: center; gap: .75rem 1.5rem; flex-wrap: wrap; }
.mfeat__label { color: var(--muted); font-size: var(--fs-xs); font-weight: 600; text-transform: uppercase; letter-spacing: .12em; }
.mfeat__list { list-style: none; margin: 0; padding: 0; display: flex; gap: .6rem; flex-wrap: wrap; }
.mfeat__list a { display: inline-flex; align-items: center; gap: .5rem; padding: .3rem .85rem .3rem .3rem; border: 1px solid var(--line); border-radius: 999px; color: var(--text); text-decoration: none; font-size: var(--fs-sm); transition: border-color .2s, color .2s, background-color .2s; }
.mfeat__list a:hover { border-color: var(--gold-line); color: var(--ink); background: var(--surface); }
.mfeat__list .mrow__mark { border-radius: 50%; width: 26px; height: 26px; }

.mfilter { display: flex; gap: .6rem; margin: 0 0 2.25rem; flex-wrap: wrap; }
.mfilter button { background: transparent; color: var(--text); border: 1px solid var(--line); padding: .5rem 1.1rem; cursor: pointer; border-radius: 999px; font: inherit; font-size: var(--fs-sm); transition: border-color .2s, background-color .2s, color .2s; }
.mfilter button:hover { border-color: var(--gold-line); color: var(--ink); }
.mfilter button[aria-pressed="true"] { background: var(--gold); color: var(--on-gold); border-color: var(--gold); font-weight: 600; }
.mfilter button:focus-visible, .mrow:focus-visible, .mfeat__list a:focus-visible { outline: 2px solid var(--gold); outline-offset: 3px; }

.mlist { display: grid; grid-template-columns: repeat(auto-fill, minmax(min(100%, 340px), 1fr)); gap: 1.75rem; margin-bottom: 2rem; }
.mrow { display: flex; flex-direction: column; background: var(--surface); text-decoration: none; border-radius: 8px; border: 1px solid var(--line); overflow: hidden; transition: border-color .25s, transform .25s, box-shadow .25s; }
.mrow[hidden] { display: none; }
.mrow:hover { border-color: var(--gold-line); transform: translateY(-4px); box-shadow: 0 12px 28px rgba(0,0,0,.4); }
.mrow__img { order: -1; display: block; background: var(--surface-2); aspect-ratio: 16/9; overflow: hidden; border-bottom: 1px solid var(--line); }
.mrow__img:empty { display: none; }
.mrow__img img { display: block; width: 100%; height: 100%; object-fit: cover; transition: transform .5s var(--ease); }
.mrow:hover .mrow__img img { transform: scale(1.04); }
.mrow__body { display: flex; flex-direction: column; flex: 1; padding: 1.4rem 1.5rem 1.5rem; }
.mrow__meta { display: flex; flex-wrap: wrap; gap: .5rem .75rem; color: var(--muted); font-size: var(--fs-xs); margin-bottom: 1rem; align-items: center; }
.mrow__meta strong { color: var(--text); font-weight: 600; font-size: var(--fs-sm); }
.mrow__mark { display: inline-flex; width: 26px; height: 26px; background: var(--mc, var(--gold)); color: #fff; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; border-radius: 4px; flex: none; }
.mrow__tag { margin-left: auto; border: 1px solid var(--gold-line); color: var(--gold); padding: .1rem .6rem; border-radius: 999px; font-size: var(--fs-xs); }
.mrow__title { color: var(--ink); margin: 0 0 .75rem; font-size: 1.15rem; line-height: 1.35; font-family: var(--serif); display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.mrow__excerpt { color: var(--muted); display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; font-size: var(--fs-sm); line-height: 1.6; margin-bottom: 1.25rem; }
.mrow__link { margin-top: auto; padding-top: 1rem; border-top: 1px solid var(--line); color: var(--gold); font-size: var(--fs-sm); display: flex; justify-content: space-between; align-items: center; gap: 1rem; }
.mrow__url { color: var(--muted); font-size: var(--fs-xs); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; min-width: 0; }
.mrow__cta { font-weight: 600; white-space: nowrap; transition: transform .25s; }
.mrow:hover .mrow__cta { transform: translateX(3px); }

@media (prefers-reduced-motion: reduce) {
    .mrow, .mrow__img img, .mrow__cta { transition: none; }
    .mrow:hover, .mrow:hover .mrow__img img, .mrow:hover .mrow__cta { transform: none; }
}
</style>
<main id="main" class="media-page">
    <section class="media-hero">
        <div class="container">
            <span class="label label--gold">Media</span>
            <h1>In the media</h1>
            <p class="lead">Coverage and commentary featuring the advocate, as published by news outlets.</p>
            <ul class="mhead__stats">
                <li><strong><?= count($mediaItems) ?></strong> articles</li>
                <li><strong><?= count($sources) ?></strong> publications</li>
                <?php
                $dates = array_filter(array_column($mediaItems, "date"));
                if ($dates) {
                    $from = date("M Y", strtotime(min($dates)));
                    $to   = date("M Y", strtotime(max($dates)));
                    echo '<li><strong>' . ($from === $to ? $from : substr($from, 0, 3) . ' – ' . $to) . '</strong> coverage period</li>';
                }
                ?>
            </ul>
        </div>
    </section>

    <?php if ($mediaItems !== []): ?>
    <section class="mfeat">
        <div class="container">
            <span class="mfeat__label">Featured in</span>
            <ul class="mfeat__list">
                <?php foreach ($sources as $name => $url):
                    $b = $mediaSources[$name] ?? null; ?>
                    <li><a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener noreferrer" style="--mc:<?= htmlspecialchars(is_array($b) ? $b["color"] : "var(--gold)") ?>">
                        <span class="mrow__mark" aria-hidden="true"><?= htmlspecialchars(is_array($b) ? $b["mark"] : strtoupper(substr($name, 0, 2))) ?></span>
                        <?= htmlspecialchars($name) ?>
                    </a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>

    <section class="section">
        <div class="container">
            <?php if ($mediaItems === []): ?>
                <p>Media coverage will be listed here shortly.</p>
            <?php else: ?>
                <?php if (count($topics) > 1): ?>
                    <div class="mfilter" role="group" aria-label="Filter by topic">
                        <button type="button" data-filter="" aria-pressed="true">All (<?= count($mediaItems) ?>)</button>
                        <?php foreach (array_keys($topics) as $t): ?>
                            <button type="button" data-filter="<?= htmlspecialchars($t) ?>" aria-pressed="false"><?= htmlspecialchars($t) ?></button>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="mlist" id="mgrid">
                    <?php foreach ($mediaItems as $m): ?>
                        <?php
                        $src = (string) ($m["source"] ?? "Media");
                        $brand = $mediaSources[$src] ?? null;
                        $mark = is_array($brand) ? $brand["mark"] : strtoupper(substr($src, 0, 2));
                        $color = is_array($brand) ? $brand["color"] : "var(--gold)";

                        $parts = parse_url((string) $m["url"]) ?: [];
                        $shown = preg_replace("#^www\.#", "", (string) ($parts["host"] ?? "")) . rtrim((string) ($parts["path"] ?? ""), "/");
                        ?>
                        <a class="mrow" href="<?= htmlspecialchars($m["url"]) ?>" target="_blank" rel="noopener noreferrer" style="--mc:<?= htmlspecialchars($color) ?>" data-topic="<?= htmlspecialchars($m["topic"] ?? "") ?>">
                            <span class="mrow__body">
                                <span class="mrow__meta">
                                    <span class="mrow__mark" aria-hidden="true"><?= htmlspecialchars($mark) ?></span>
                                    <strong><?= htmlspecialchars($src) ?></strong>
                                    <?php if (!empty($m["date"])): ?><span><?= htmlspecialchars(date("j M Y", strtotime($m["date"]))) ?></span><?php endif; ?>
                                    <?php if (!empty($m["topic"])): ?><span class="mrow__tag"><?= htmlspecialchars($m["topic"]) ?></span><?php endif; ?>
                                </span>
                                <h3 class="mrow__title"><?= htmlspecialchars($m["title"]) ?></h3>
                                <?php if (!empty($m["excerpt"])): ?><span class="mrow__excerpt"><?= htmlspecialchars($m["excerpt"]) ?></span><?php endif; ?>
                                <span class="mrow__link">
                                    <span class="mrow__url"><?= htmlspecialchars($shown) ?></span>
                                    <span class="mrow__cta">Read article &rarr;</span>
                                </span>
                            </span>
                            <span class="mrow__img">
                                <?php if (!empty($m["image"])): ?>
                                    <img src="<?= htmlspecialchars($m["image"]) ?>" alt="" loading="lazy">
                                <?php endif; ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>

                <script>
                (function () {
                    var bar = document.querySelector(".mfilter");
                    if (!bar) return;
                    bar.addEventListener("click", function (ev) {
                        var b = ev.target.closest("button");
                        if (!b) return;
                        var f = b.getAttribute("data-filter");
                        bar.querySelectorAll("button").forEach(function (x) {
                            x.setAttribute("aria-pressed", x === b ? "true" : "false");
                        });
                        document.querySelectorAll("#mgrid .mrow").forEach(function (c) {
                            c.hidden = f !== "" && c.getAttribute("data-topic") !== f;
                        });
                    });
                })();
                </script>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>

