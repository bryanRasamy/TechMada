<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

      <!-- Formulaire ajout Type Congé -->
      <div class="form-section">
        <h3><i class="bi bi-tags-fill" style="color:var(--forest);margin-right:6px"></i>Ajouter un Type de Congé</h3>
        
        <?php if (session()->getFlashdata('error')){ ?>
            <div class="flash flash-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php } ?>
        <?php if (session()->getFlashdata('success')){ ?>
            <div class="flash flash-success">
                <i class="bi bi-check-circle-fill"></i>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php } ?>

        <form action="<?= base_url('admin/types-conge/ajouter') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
                <label class="f-label">Libellé du congé</label>
                <input type="text" name="libelle" class="f-input" placeholder="Congé Maternité" required/>
            </div>
            <div class="f-group">
                <label class="f-label">Jours annuels alloués (optionnel)</label>
                <input type="number" name="jours_annuels" class="f-input" placeholder="30" />
            </div>
            <div class="f-group">
                <label class="f-label">Déductible du solde annuel ?</label>
                <select name="deductible" class="f-select" required>
                    <option value="1">Oui</option>
                    <option value="0">Non</option>
                </select>
            </div>
            </div>
            <div class="form-actions">
            <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer le type de congé</button>
            <button type="reset" class="btn-secondary">Réinitialiser</button>
            </div>
        </form>
      </div>

      <!-- Liste Types Congés -->
      <div class="data-card mt-4">
        <div class="data-card-head">
          <h3>Liste des Types de Congé</h3>
        </div>
        <table class="tbl">
          <thead>
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Jours Annuels</th>
                <th>Déductible</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($types_conges as $tc){ ?>
            <tr>
              <td class="td-muted td-mono" style="font-size:.78rem">#<?= esc($tc['id']) ?></td>
              <td style="font-weight:600;"><?= esc($tc['libelle']) ?></td>
              <td><?= esc($tc['jours_annuels'] ?? '-') ?> <span class="td-muted">jours</span></td>
              <td>
                  <?php if((bool)$tc['deductible']){ ?>
                      <span class="type-badge t-annuel">Oui</span>
                  <?php } else { ?>
                      <span class="type-badge t-maladie" style="background:#f1efe8;color:#444441">Non</span>
                  <?php } ?>
              </td>
              <td>
                <div class="action-btns">
                  <button class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                </div>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

<?= $this->endSection() ?>
