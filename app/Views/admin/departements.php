<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

      <!-- Formulaire ajout Département -->
      <div class="form-section">
        <h3><i class="bi bi-building-add" style="color:var(--forest);margin-right:6px"></i>Ajouter un Département</h3>
        
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="flash flash-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="flash flash-success">
                <i class="bi bi-check-circle-fill"></i>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif ?>

        <form action="<?= base_url('admin/departements/ajouter') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
                <label class="f-label">Nom du département</label>
                <input type="text" name="nom" class="f-input" placeholder="Ressources Humaines" required/>
            </div>
            <div class="f-group">
                <label class="f-label">Description (optionnelle)</label>
                <input type="text" name="description" class="f-input" placeholder="Recrutement direct" />
            </div>
            </div>
            <div class="form-actions">
            <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer le département</button>
            <button type="reset" class="btn-secondary">Réinitialiser</button>
            </div>
        </form>
      </div>

      <!-- Liste Départements -->
      <div class="data-card mt-4">
        <div class="data-card-head">
          <h3>Liste des Départements</h3>
        </div>
        <table class="tbl">
          <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($departements as $dept): ?>
            <tr>
              <td class="td-muted td-mono" style="font-size:.78rem">#<?= esc($dept['id']) ?></td>
              <td style="font-weight:600;"><?= esc($dept['nom']) ?></td>
              <td class="td-muted"><?= esc($dept['description'] ?? 'Aucune description') ?></td>
              <td>
                <div class="action-btns">
                  <button class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

<?= $this->endSection() ?>
