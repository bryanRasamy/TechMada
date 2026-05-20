<?= $this->extend('layout') ?>
<?= $this->section('head') ?>
<link href="<?= base_url('assets/css/fullcalendar.min.css') ?>" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="card shadow-sm border-0 mt-4">
    <div class="card-body p-4">
        <h2 class="card-title h4 mb-4" style="font-family: 'Playfair Display', serif; color: #2C3E50;">
            <i class="bi bi-calendar-week me-2 text-primary"></i>Calendrier de mes congés
        </h2>
        
        <div id='calendar'></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/fullcalendar.min.js') ?>"></script>
<script src="<?= base_url('assets/js/locales-all.min.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                <?php foreach($conges as $conge){ ?>
                {
                    title: '<?= esc($conge['type_conge_nom'] ?? 'Congé') . " (" . esc($conge['statut']) . ")" ?>',
                    start: '<?= $conge['date_debut'] ?>',
                    end: '<?= date('Y-m-d', strtotime($conge['date_fin'] . ' +1 day')) ?>',
                    color: '<?= $conge['statut'] == 'accepte' ? '#2ecc71' : ($conge['statut'] == 'en_attente' ? '#f39c12' : '#e74c3c') ?>',
                    textColor: 'white'
                },
                <?php } ?>
            ]
        });
        calendar.render();
    });
</script>
<?= $this->endSection() ?>
