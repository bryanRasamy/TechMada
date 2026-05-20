<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<section id="page-form-conge" style="margin-top:3rem">
  <div class="app-wrap">
    <div class="content">
      <?php $errors = session('errors') ?? []; ?>
      <form action="<?= base_url('employe/nouvelle-demande/ajout') ?>" method="post">
        <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start" class="form-layout">

          <div>
            <div class="form-section">
              <h3>Détails de la demande</h3>

              <div class="f-group" style="margin-bottom:1rem">
                <label class="f-label">Type de congé <span style="color:var(--danger)">*</span></label>
                <select name="type_conge_id" class="f-select">
                  <option value="">-- Choisir un type --</option>
                  <?php foreach ($typesConge as $type) { ?>
                    <option value="<?= esc($type['id']) ?>" <?php if (old('type_conge_id') == $type['id']) { echo 'selected'; } ?>>
                      <?= esc($type['libelle']) ?>
                    </option>
                  <?php } ?>
                </select>
                <?php if (! empty($errors['type_conge_id'])) { ?>
                  <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['type_conge_id']) ?></div>
                <?php } ?>
              </div>

              <div class="form-grid-2" style="margin-bottom:1rem">
                <div class="f-group">
                  <label class="f-label">Date de début <span style="color:var(--danger)">*</span></label>
                  <input type="date" name="date_debut" value="<?= esc(old('date_debut')) ?>" class="f-input" />
                  <?php if (! empty($errors['date_debut'])) { ?>
                    <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['date_debut']) ?></div>
                  <?php } ?>
                </div>
                <div class="f-group">
                  <label class="f-label">Date de fin <span style="color:var(--danger)">*</span></label>
                  <input type="date" name="date_fin" value="<?= esc(old('date_fin')) ?>" class="f-input" />
                  <?php if (! empty($errors['date_fin'])) { ?>
                    <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['date_fin']) ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="f-computed">
                <div class="f-computed-num"><?= esc(old('nb_jours') ?: '0') ?></div>
                <div class="f-computed-label">jours calendaires calculés<br><span style="font-size:.7rem;opacity:.7">Sélectionnez vos dates pour calculer automatiquement</span></div>
              </div>

              <div class="f-group" style="margin-bottom:1rem">
                <label class="f-label">Motif <span style="color:var(--danger)">*</span></label>
                <textarea name="motif" class="f-textarea" rows="5"><?= esc(old('motif')) ?></textarea>
                <?php if (! empty($errors['motif'])) { ?>
                  <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= esc($errors['motif']) ?></div>
                <?php } ?>
                <div class="f-hint">Le motif est visible par le responsable RH.</div>
              </div>

              <div class="form-actions">
                <button class="btn-forest" type="submit"><i class="bi bi-send"></i> Soumettre la demande</button>
                <a href="<?= base_url('employe/mes-demandes') ?>" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
              </div>
            </div>
          </div>

          <div style="display:flex;flex-direction:column;gap:1rem">
            <div class="data-card" style="margin:0">
              <div class="data-card-head"><h3><i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>Vos soldes actuels</h3></div>
              <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
                <div>
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-size:.8rem;color:var(--ink)">Congé annuel</span>
                    <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--forest);font-weight:500">18 j</span>
                  </div>
                  <div class="solde-bar"><div class="solde-fill" style="width:60%"></div></div>
                </div>
                <div>
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-size:.8rem;color:var(--ink)">Maladie</span>
                    <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--forest);font-weight:500">8 j</span>
                  </div>
                  <div class="solde-bar"><div class="solde-fill" style="width:80%"></div></div>
                </div>
                <div>
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-size:.8rem;color:var(--ink)">Spécial</span>
                    <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--warn);font-weight:500">1 j</span>
                  </div>
                  <div class="solde-bar"><div class="solde-fill warn" style="width:20%"></div></div>
                </div>
              </div>
            </div>
            <div class="flash flash-info" style="margin:0">
              <i class="bi bi-info-circle-fill"></i>
              <span style="font-size:.8rem">Le solde est déduit uniquement à l'approbation de votre responsable.</span>
            </div>
            <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem">
              <div style="font-size:.78rem;font-weight:500;color:var(--ink);margin-bottom:.5rem"><i class="bi bi-clipboard-check" style="color:var(--forest);margin-right:5px"></i>Rappel des règles</div>
              <ul style="margin:0;padding-left:1rem;font-size:.75rem;color:var(--muted);line-height:1.7">
                <li>Préavis minimum : 48h avant la date de début</li>
                <li>Pas de chevauchement avec une demande en cours</li>
                <li>Solde insuffisant = demande refusée automatiquement</li>
              </ul>
            </div>
          </div>

        </div>
      </form>
  
</section>

<?= $this->endSection() ?>
