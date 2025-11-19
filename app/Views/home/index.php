<?= $this->extend('shared/layout_home') ?>

<?= $this->section('content') ?>
<main class="app-main">
    <section class="intro-section fade-in text-center py-5 shadow-sm">
        <div class="intro-content d-flex flex-column align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
                <div class="hris-badge">WMiS</div>
                <div class="intro-text text-start">
                    <h1 class="fw-bold text-gradient m-0">Warehouse Management</h1>
                    <h1 class="fw-bold text-gradient m-0">Information System</h1>
                </div>
            </div>
            <p class="tagline">Optimizing Storage, Streamlining Operations</p>
        </div>
    </section>
    <div class="app-content">
        <div class="container-fluid">
            <section class="feature-section fade-in py-2">
                <div class="row g-3 justify-content-center align-items-stretch">
                    <?php
                    $card = [
                        ['title' => 'Good Receipt', 'desc' => 'Record and manage incoming goods efficiently.', 'img' => 'fa-solid fa-truck-loading', 'link' => 'process/good_receipt_image'],
                        ['title' => 'Put Away', 'desc' => 'Organize and store materials in optimal locations.', 'img' => 'fa-solid fa-box-open', 'link' => 'process/put_away'],
                        ['title' => 'Picking', 'desc' => 'Accurately pick items for orders and shipments.', 'img' => 'fa-solid fa-shopping-cart', 'link' => 'process/picking'],
                        ['title' => 'Cycle Count', 'desc' => 'Maintain accurate inventory through regular counting.', 'img' => 'fa-solid fa-sync-alt', 'link' => 'process/cycle_count'],
                    ];
                    ?>
                    <?php foreach ($card as $c): ?>
                        <div class="col-md-6">
                            <a href="<?= base_url($c['link']); ?>" class="card-link">
                                <div class="card split-card h-100">
                                    <div class="card-left d-flex justify-content-center align-items-center">
                                        <!-- <img src="<?= base_url('assets/img/' . $c['img']); ?>" alt="<?= $c['title']; ?>" class="card-img"> -->
                                        <i class="<?= $c['img']; ?> card-icon"></i>
                                    </div>
                                    <div class="card-right">
                                        <h5><?= $c['title']; ?></h5>
                                        <p><?= $c['desc']; ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

        </div>
    </div>
</main>

<style>
    .text-gradient {
        background: #f8f9fa;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .fade-in {
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .intro-section {
        position: relative;
        background: url('<?= base_url("assets/img/image_home_cut.jpg") ?>') no-repeat center/cover;
        padding: 5rem 1rem;
        overflow: hidden;
    }

    body {
        padding: 0;
        margin: 0;
    }

    .intro-section::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.55);
        z-index: 1;
    }

    .intro-content {
        position: relative;
        z-index: 2;
    }

    .hris-badge {
        background: linear-gradient(135deg, #5f0188, #6f1a94);
        color: #f8f9fa;
        font-weight: 700;
        font-size: 3rem;
        padding: 0.5rem 1.2rem;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(95, 1, 136, 0.3);
    }

    .intro-text h1 {
        font-size: 2rem;
        line-height: 1.1;
    }

    .tagline {
        font-size: 1.15rem;
        color: #f8f9fa;
        font-weight: 500;
        padding-top: 1.2rem;
    }

    .split-card {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        position: relative;
        padding: 0.6rem;
    }

    .split-card:hover {
        transform: translateY(-4px) scale(1.03);
        box-shadow: 0 12px 25px rgba(111, 26, 148, 0.35);
    }

    .card-left {
        position: relative;
        flex: 0 0 160px;
        min-width: 160px;
        background-color: #e0d2ea;
        border-radius: 10px;
    }

    .card-img {
        position: absolute;
        z-index: 2;
        height: auto;
        width: 90%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .card-icon {
        font-size: 4rem;
        color: #5f0188;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .card-right {
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1rem;
    }

    .card-right h5 {
        color: #f4922e;
        font-weight: 600;
        font-size: 1.7rem;
        margin-bottom: 0.25rem;
    }

    .card-right p {
        font-size: 0.95rem;
        color: #5f0188;
        margin: 0;
        font-weight: 600;
    }

    .card-link {
        text-decoration: none;
    }

    @media (max-width:768px) {
        .card-left {
            flex: 0 0 80px;
        }

        .intro-text h1 {
            font-size: 1.6rem;
        }

        .hris-badge {
            font-size: 1.8rem;
            padding: 0.4rem 0.9rem;
        }

        .tagline {
            font-size: 1rem;
        }
    }
</style>

<?= $this->endSection() ?>