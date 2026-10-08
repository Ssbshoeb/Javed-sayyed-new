
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
.media-hero { padding: 4rem 0 2rem; border-bottom: 1px solid var(--line); }
.media-hero h1 { color: var(--gold); }
.media-hero .mhead__stats { list-style: none; padding: 0; display: flex; gap: 2rem; margin-top: 1.5rem; color: var(--muted); }
.media-hero .mhead__stats strong { color: var(--gold); font-size: 1.5rem; }

.mfilter { display: flex; gap: 1rem; margin: 2rem 0; flex-wrap: wrap; }
.mfilter button { background: var(--surface); color: var(--text); border: 1px solid var(--line); padding: 0.5rem 1rem; cursor: pointer; border-radius: 4px; }
.mfilter button[aria-pressed="true"] { background: var(--gold); color: var(--on-gold); border-color: var(--gold); }

.mlist { display: grid; gap: 2rem; margin-bottom: 4rem; }
.mrow { display: grid; grid-template-columns: 1fr 300px; gap: 2rem; background: var(--surface); padding: 1.5rem; text-decoration: none; border-radius: 8px; border: 1px solid var(--line); transition: border-color 0.2s, opacity 0.8s, transform 0.8s; }
.mrow:hover { border-color: var(--gold-line); }
.mrow__meta { display: flex; gap: 1rem; color: var(--muted); font-size: var(--fs-sm); margin-bottom: 0.5rem; align-items: center; }
.mrow__mark { display: inline-flex; width: 24px; height: 24px; background: var(--mc, var(--gold)); color: #fff; align-items: center; justify-content: center; font-size: 10px; font-weight: bold; border-radius: 4px; }
.mrow__title { color: var(--ink); margin: 0 0 0.5rem; font-size: var(--fs-h4); }
.mrow__excerpt { color: var(--text); display: block; margin-bottom: 1rem; }
.mrow__link { color: var(--gold); font-size: var(--fs-sm); font-weight: 500; display: flex; justify-content: space-between; }
.mrow__img { border-radius: 4px; overflow: hidden; background: #000; }
.mrow__img img { width: 100%; height: 100%; object-fit: cover; aspect-ratio: 3/2; }

@media (max-width: 768px) {
    .mrow { grid-template-columns: 1fr; }
    .mrow__img { order: -1; }
}
</style>
<main id="main" class="media-page">
    <section class="media-hero">
        <div class="container">
            <h1>In the media</h1>
            <p class="lead">Coverage and commentary featuring the advocate, as published by news outlets.</p>
            <ul class="mhead__stats">
                <li><strong><?= count($mediaItems) ?></strong> articles</li>
                <li><strong><?= count($sources) ?></strong> publications</li>
            </ul>
        </div>
    </section>

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

<style>.mrow:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.4); }</style>
