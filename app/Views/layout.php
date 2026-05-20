<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'TechMada RH') ?></title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/bootstrap-icons.min.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/fonts.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('assets/app.css') ?>">
    <?= $this->renderSection('head') ?>
</head>

<body>
    <section id="page-dashboard-employe">
        <div class="app-wrap">
                        <aside class="sidebar">
                <?php $role = session()->get('user')['role'] ?? 'employe'; ?>
                <div class="sidebar-brand">
                    <?php if ($role === 'admin'): ?>
                        <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
                        <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
                    <?php else: ?>
                        <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
                        <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
                    <?php endif; ?>
                </div>

                <?php if ($role === 'admin'): ?>
                    <ul class="sidebar-nav" style="margin-top:1rem">
                        <li><a href="<?= base_url('admin/dashboard') ?>" class="<?= url_is('admin/dashboard') ? 'active' : '' ?>"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
                        <li><a href="<?= base_url('admin/demandes') ?>" class="<?= url_is('admin/demandes') ? 'active' : '' ?>"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
                        <li><a href="<?= base_url('admin/employes') ?>" class="<?= url_is('admin/employes') ? 'active' : '' ?>"><i class="bi bi-people"></i> Employés</a></li>
                        <li><a href="<?= base_url('admin/departements') ?>" class="nav-link <?= url_is('admin/departements') ? 'active' : '' ?>" class="<?= url_is('admin/departements') ? 'active' : '' ?>"><i class="bi bi-building"></i> Départements</a></li>
                        <li><a href="<?= base_url('admin/types-conge') ?>" class="<?= url_is('admin/types-conge') ? 'active' : '' ?>"><i class="bi bi-tags"></i> Types de congé</a></li>
                    </ul>
                <?php else: ?>
                    <div class="sidebar-section">Menu</div>
                    <ul class="sidebar-nav">
                        <li><a href="<?= base_url('employe/dashboard') ?>" class="<?= url_is('employe/dashboard') ? 'active' : '' ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
                        <li><a href="<?= base_url('employe/nouvelle-demande') ?>" class="<?= url_is('employe/nouvelle-demande') ? 'active' : '' ?>"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
                        <li>
                            <a href="<?= base_url('employe/mes-demandes') ?>" class="<?= url_is('employe/mes-demandes') ? 'active' : '' ?>">
                                <i class="bi bi-journal-text"></i> Mes demandes
                                <span class="nav-badge alert"><?= esc((string) ($nombreDemandesEnAttente ?? 0)) ?></span>
                            </a>
                        </li>
                        <li><a href="<?= base_url('employe/calendrier') ?>" class="<?= url_is('employe/calendrier') ? 'active' : '' ?>"><i class="bi bi-calendar3"></i> Mon Calendrier</a></li>
                        <li><a href="<?= base_url('employe/profil') ?>" class="<?= url_is('employe/profil') ? 'active' : '' ?>"><i class="bi bi-person"></i> Mon profil</a></li>
                    </ul>
                <?php endif; ?>

                <div class="sidebar-user">
                    <div class="s-user-row">
                        <?php if ($role === 'admin'): ?>
                            <div class="avatar" style="background:#5a2d82;width:32px;height:32px;font-size:.7rem"><?= esc($initialesEmploye ?? 'AD') ?></div>
                        <?php else: ?>
                            <div class="avatar av-green"><?= esc($initialesEmploye ?? 'EM') ?></div>
                        <?php endif; ?>
                        <div>
                            <div class="user-name"><?= esc($nomEmploye ?? 'Utilisateur') ?></div>
                            <div class="user-role"><?= esc($departementEmploye ?? 'Non renseigné') ?></div>
                        </div>
                        <a href="<?= base_url('logout') ?>" style="margin-left:auto;color:rgba(255,255,255,.25);font-size:1.1rem" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
                    </div>
                </div>
            </aside>

            <div class="main">
                <div class="topbar">
                    <div>
                        <div class="topbar-title"><?= esc($title ?? 'TechMada RH') ?></div>
                        <div class="topbar-breadcrumb">Accueil</div>
                    </div>
                    <div class="topbar-actions">
                        <a href="<?= base_url('employe/nouvelle-demande') ?>" class="btn-forest" style="padding:7px 14px;font-size:.82rem">
                            <i class="bi bi-plus-lg"></i> Nouvelle demande
                        </a>
                    </div>
                </div>


                <div class="content">
                    <?= $this->renderSection('content') ?>
                </div>


                <div class="footer-app"><i class="bi bi-c-circle"></i> 2026 <span>TechMada RH</span> — Projet CodeIgniter 4</div>
            </div>
        </div>
    </section>
    
    <?= $this->renderSection('scripts') ?>
</body>

</html>