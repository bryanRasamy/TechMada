<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

      <!-- Formulaire ajout -->
      <div class="form-section">
        <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
        
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

        <form action="<?= base_url('admin/employes/ajouter') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
                <label class="f-label">Prénom</label>
                <input type="text" name="prenom" class="f-input" placeholder="Jean" required/>
            </div>
            <div class="f-group">
                <label class="f-label">Nom</label>
                <input type="text" name="nom" class="f-input" placeholder="Rakoto" required/>
            </div>
            <div class="f-group">
                <label class="f-label">Email</label>
                <input type="email" name="email" class="f-input" placeholder="jean.rakoto@techmada.mg" required/>
            </div>
            <div class="f-group">
                <label class="f-label">Mot de passe initial</label>
                <input type="password" name="password" class="f-input" placeholder="À communiquer à l'employé" required/>
            </div>
            <div class="f-group">
                <label class="f-label">Département</label>
                <select name="departement_id" class="f-select" required>
                <?php foreach($departements as $dept){ ?>
                    <option value="<?= $dept['id'] ?>"><?= esc($dept['nom']) ?></option>
                <?php } ?>
                </select>
            </div>
            <div class="f-group">
                <label class="f-label">Rôle</label>
                <select name="role" class="f-select" required>
                <option value="employe">Employé</option>
                <option value="rh">Responsable RH</option>
                <option value="admin">Administrateur</option>
                </select>
            </div>
            <div class="f-group">
                <label class="f-label">Date d'embauche</label>
                <input type="date" name="date_embauche" class="f-input" value="<?= date('Y-m-d') ?>" required/>
            </div>
            </div>
            <div class="flash flash-info" style="margin-bottom:1rem">
            <i class="bi bi-info-circle-fill"></i>
            <span style="font-size:.82rem">Les soldes de congés seront initialisés automatiquement selon les types de congé configurés.</span>
            </div>
            <div class="form-actions">
            <button type="submit" class="btn-forest"><i class="bi bi-plus"></i> Créer l'employé</button>
            <button type="reset" class="btn-secondary">Réinitialiser</button>
            </div>
        </form>
      </div>

      <!-- Liste employés -->
      <div class="data-card mt-4">
        <div class="data-card-head">
          <h3>Tous les employés</h3>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Employé</th><th>Département</th><th>Rôle</th><th>Embauche</th><th>Statut</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php foreach($employes as $emp){ ?>
            <tr <?= !$emp['actif'] ? 'style="opacity:.5"' : '' ?>>
              <td>
                <div class="profile-row">
                  <?php
                     $initiales = strtoupper(substr($emp['prenom'], 0, 1) . substr($emp['nom'], 0, 1));
                     $colorClass = $emp['role'] == 'admin' ? 'av-amber' : ($emp['role'] == 'rh' ? 'av-blue' : 'av-green');
                  ?>
                  <div class="avatar <?= $colorClass ?>" style="width:32px;height:32px;font-size:.68rem"><?= esc($initiales) ?></div>
                  <div class="profile-info"><div class="pname"><?= esc($emp['prenom'] .' '. $emp['nom']) ?></div><div class="pdept"><?= esc($emp['email']) ?></div></div>
                </div>
              </td>
              <td class="td-muted"><?= esc($emp['nom_departement'] ?? 'N/A') ?></td>
              <td>
                  <?php if($emp['role'] == 'admin'){ ?>
                      <span class="type-badge t-annuel">admin</span>
                  <?php } elseif($emp['role'] == 'rh') { ?>
                      <span class="type-badge t-maladie">rh</span>
                  <?php } else { ?>
                      <span class="type-badge" style="background:#f1efe8;color:#444441">employe</span>
                  <?php } ?>
              </td>
              <td class="td-muted td-mono" style="font-size:.78rem"><?= esc($emp['date_embauche']) ?></td>
              <td>
                  <?php if($emp['actif']){ ?>
                      <span class="statut s-approuvee" style="font-size:.68rem">actif</span>
                  <?php } else { ?>
                      <span class="statut s-annulee" style="font-size:.68rem">inactif</span>
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