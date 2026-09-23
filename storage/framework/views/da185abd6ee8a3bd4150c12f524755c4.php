<?php $__env->startSection('title', 'Créer un compte candidat — ENEF'); ?>

<?php $__env->startSection('content'); ?>

    <section style="padding:60px 0;">
        <div class="container">
            <div class="auth-grid">

                
                <div class="auth-side">
                    <div class="eyebrow-line"><span class="rule"></span> Espace candidat</div>
                    <h2 style="color:#fff;max-width:14ch;">Rejoignez l'École Nationale des Eaux et Forêts</h2>
                    <p style="color:#d9e4d6;font-size:15.5px;max-width:36ch;">
                        Créez votre compte pour déposer votre dossier de candidature, suivre son instruction en
                        temps réel et consulter les résultats dès leur publication.
                    </p>
                    <ul class="auth-perks">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            Ouvert aux candidats nationaux et internationaux
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            Dépôt de dossier 100% en ligne
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>
                            Suivre son dossier
                        </li>
                    </ul>
                </div>

                
                <div class="auth-card">
                    <h3 style="margin-bottom:6px;">Créer un compte candidat</h3>
                    <p style="color:var(--ink-soft);font-size:14px;margin-bottom:24px;">
                        Déjà inscrit ?
                        <a href="<?php echo e(route('login')); ?>"
                            style="color:var(--forest-mid);font-weight:700;text-decoration:underline;">Connectez-vous</a>
                    </p>

                    <?php if($errors->any()): ?>
                        <div class="auth-alert">
                            <strong>Merci de corriger les erreurs suivantes :</strong>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('storeInscription')); ?>" novalidate id="registerForm">
                        <?php echo csrf_field(); ?>

                        
                        <div class="form-row">
                            <label>Type de candidature</label>
                            <div class="nat-toggle">
                                <label class="nat-option">
                                    <input type="radio" name="nationalite_type" value="nationale"
                                        <?php echo e(old('nationalite_type', 'nationale') === 'nationale' ? 'checked' : ''); ?>>
                                    <span>Candidat national (Burkina Faso)</span>
                                </label>
                                <label class="nat-option">
                                    <input type="radio" name="nationalite_type" value="internationale"
                                        <?php echo e(old('nationalite_type') === 'internationale' ? 'checked' : ''); ?>>
                                    <span>Candidat international</span>
                                </label>
                            </div>
                            <?php $__errorArgs = ['nationalite_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="field-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-row" id="rowPaysNationalite"
                            style="<?php echo e(old('nationalite_type') === 'internationale' || $errors->has('pays_nationalite') ? 'display:block' : 'display:none'); ?>">
                            <label for="pays_nationalite">Pays de nationalité</label>
                            <input id="pays_nationalite" type="text" name="pays_nationalite"
                                value="<?php echo e(old('pays_nationalite')); ?>"
                                class="<?php echo e($errors->has('pays_nationalite') ? 'is-invalid' : ''); ?>"
                                placeholder="Ex. Côte d'Ivoire">
                            <?php $__errorArgs = ['pays_nationalite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="field-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-row-split">
                            <div class="form-row">
                                <label for="prenom">Prénom(s)</label>
                                <input id="prenom" type="text" name="prenom" value="<?php echo e(old('prenom')); ?>"
                                    class="<?php echo e($errors->has('prenom') ? 'is-invalid' : ''); ?>" autocomplete="given-name"
                                    autofocus required placeholder="Ex. Aïcha">
                                <?php $__errorArgs = ['prenom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-row">
                                <label for="nom">Nom</label>
                                <input id="nom" type="text" name="nom" value="<?php echo e(old('nom')); ?>"
                                    class="<?php echo e($errors->has('nom') ? 'is-invalid' : ''); ?>" autocomplete="family-name"
                                    required placeholder="Ex. KABORÉ">
                                <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-row-split">
                            <div class="form-row">
                                <label for="sexe">Sexe</label>
                                <select id="sexe" name="sexe"
                                    class="<?php echo e($errors->has('sexe') ? 'is-invalid' : ''); ?>" required>
                                    <option value="">Sélectionner</option>
                                    <option value="F" <?php echo e(old('sexe') === 'F' ? 'selected' : ''); ?>>Féminin</option>
                                    <option value="M" <?php echo e(old('sexe') === 'M' ? 'selected' : ''); ?>>Masculin</option>
                                </select>
                                <?php $__errorArgs = ['sexe'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-row">
                                <label for="date_naissance">Date de naissance</label>
                                <input id="date_naissance" type="date" name="date_naissance"
                                    value="<?php echo e(old('date_naissance')); ?>"
                                    class="<?php echo e($errors->has('date_naissance') ? 'is-invalid' : ''); ?>" required>
                                <?php $__errorArgs = ['date_naissance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="lieu_naissance">Lieu de naissance</label>
                            <input id="lieu_naissance" type="text" name="lieu_naissance"
                                value="<?php echo e(old('lieu_naissance')); ?>"
                                class="<?php echo e($errors->has('lieu_naissance') ? 'is-invalid' : ''); ?>" required
                                placeholder="Ville, pays">
                            <?php $__errorArgs = ['lieu_naissance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="field-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-row-split">
                            <div class="form-row">
                                <label for="piece_type">Pièce d'identité</label>
                                <select id="piece_type" name="piece_type"
                                    class="<?php echo e($errors->has('piece_type') ? 'is-invalid' : ''); ?>" required>
                                    <option value="cnib" <?php echo e(old('piece_type', 'cnib') === 'cnib' ? 'selected' : ''); ?>>
                                        CNIB</option>
                                    <option value="passeport" <?php echo e(old('piece_type') === 'passeport' ? 'selected' : ''); ?>>
                                        Passeport</option>
                                </select>
                                <?php $__errorArgs = ['piece_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-row">
                                <label for="piece_numero" id="labelPieceNumero">Numéro CNIB</label>
                                <input id="piece_numero" type="text" name="piece_numero"
                                    value="<?php echo e(old('piece_numero')); ?>"
                                    class="<?php echo e($errors->has('piece_numero') ? 'is-invalid' : ''); ?>" required
                                    placeholder="Ex. B01234567">
                                <?php $__errorArgs = ['piece_numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="form-row">
                            <label for="email">Adresse e-mail</label>
                            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                                class="<?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>" autocomplete="username" required
                                placeholder="vous@exemple.com">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="field-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-row-split form-row-split--phone">
                            <div class="form-row">
                                <label for="telephone_indicatif">Indicatif</label>
                                <select id="telephone_indicatif" name="telephone_indicatif"
                                    class="<?php echo e($errors->has('telephone_indicatif') ? 'is-invalid' : ''); ?>" required>
                                    <option value="+226"
                                        <?php echo e(old('telephone_indicatif', '+226') === '+226' ? 'selected' : ''); ?>>🇧🇫 +226
                                        (Burkina Faso)</option>
                                    <option value="+225" <?php echo e(old('telephone_indicatif') === '+225' ? 'selected' : ''); ?>>
                                        🇨🇮 +225 (Côte d'Ivoire)</option>
                                    <option value="+223" <?php echo e(old('telephone_indicatif') === '+223' ? 'selected' : ''); ?>>
                                        🇲🇱 +223 (Mali)</option>
                                    <option value="+227" <?php echo e(old('telephone_indicatif') === '+227' ? 'selected' : ''); ?>>
                                        🇳🇪 +227 (Niger)</option>
                                    <option value="+228" <?php echo e(old('telephone_indicatif') === '+228' ? 'selected' : ''); ?>>
                                        🇹🇬 +228 (Togo)</option>
                                    <option value="+229" <?php echo e(old('telephone_indicatif') === '+229' ? 'selected' : ''); ?>>
                                        🇧🇯 +229 (Bénin)</option>
                                    <option value="+221" <?php echo e(old('telephone_indicatif') === '+221' ? 'selected' : ''); ?>>
                                        🇸🇳 +221 (Sénégal)</option>
                                    <option value="+233" <?php echo e(old('telephone_indicatif') === '+233' ? 'selected' : ''); ?>>
                                        🇬🇭 +233 (Ghana)</option>
                                    <option value="+33" <?php echo e(old('telephone_indicatif') === '+33' ? 'selected' : ''); ?>>
                                        🇫🇷 +33 (France)</option>
                                    <option value="autre" <?php echo e(old('telephone_indicatif') === 'autre' ? 'selected' : ''); ?>>
                                        Autre</option>
                                </select>
                                <?php $__errorArgs = ['telephone_indicatif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-row">
                                <label for="telephone">Numéro de téléphone</label>
                                <input id="telephone" type="tel" name="telephone" value="<?php echo e(old('telephone')); ?>"
                                    class="<?php echo e($errors->has('telephone') ? 'is-invalid' : ''); ?>" required
                                    placeholder="Ex. 70 00 00 00">
                                <?php $__errorArgs = ['telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="form-row">
                            <label for="adresse">Adresse</label>
                            <input id="adresse" type="text" name="adresse" value="<?php echo e(old('adresse')); ?>"
                                class="<?php echo e($errors->has('adresse') ? 'is-invalid' : ''); ?>" required
                                placeholder="Quartier, secteur, rue...">
                            <?php $__errorArgs = ['adresse'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="field-error"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-row-split">
                            <div class="form-row">
                                <label for="ville">Ville</label>
                                <input id="ville" type="text" name="ville" value="<?php echo e(old('ville')); ?>"
                                    class="<?php echo e($errors->has('ville') ? 'is-invalid' : ''); ?>" required
                                    placeholder="Ex. Bobo-Dioulasso">
                                <?php $__errorArgs = ['ville'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-row">
                                <label for="pays_residence">Pays de résidence</label>
                                <input id="pays_residence" type="text" name="pays_residence"
                                    value="<?php echo e(old('pays_residence', 'Burkina Faso')); ?>"
                                    class="<?php echo e($errors->has('pays_residence') ? 'is-invalid' : ''); ?>" required>
                                <?php $__errorArgs = ['pays_residence'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div class="form-row-split">
                            <div class="form-row">
                                <label for="password">Mot de passe</label>
                                <input id="password" type="password" name="password"
                                    class="<?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>"
                                    autocomplete="new-password" required placeholder="8 caractères minimum">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="field-error"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-row">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    autocomplete="new-password" required placeholder="Répétez le mot de passe">
                            </div>
                        </div>

                        <label class="checkbox-row">
                            <input type="checkbox" name="terms" required>
                            <span>J'accepte les <a href="#">conditions d'utilisation</a> et la
                                <a href="#">politique de confidentialité</a> de l'ENEF.</span>
                        </label>
                        <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="field-error d-block"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <button type="submit" class="btn btn-primary" style="width:100%;margin-top:8px;">
                            Créer mon compte
                        </button>
                    </form>

                    <div class="auth-divider"><span>ou</span></div>

                    <a href="<?php echo e(url('/')); ?>" class="btn btn-outline" style="width:100%;">
                        Retour à l'accueil
                    </a>
                </div>

            </div>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .auth-grid {
            display: grid;
            grid-template-columns: .8fr 1.2fr;
            gap: 0;
            border: 1px solid var(--line);
            background: var(--white);
        }

        .auth-side {
            background: linear-gradient(165deg, #254a34, #153a49);
            color: #fff;
            padding: 52px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-side::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(500px 340px at 90% 10%, rgba(127, 166, 107, .28), transparent 60%);
        }

        .auth-side>* {
            position: relative;
            z-index: 1;
        }

        .auth-side h2 {
            margin: 14px 0 16px;
            font-size: 27px;
            line-height: 1.2;
        }

        .auth-perks {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .auth-perks li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            color: #dbe6d8;
        }

        .auth-perks svg {
            width: 18px;
            height: 18px;
            color: var(--leaf);
            flex-shrink: 0;
            background: rgba(127, 166, 107, .18);
            border-radius: 50%;
            padding: 3px;
            box-sizing: content-box;
        }

        .auth-card {
            padding: 48px 44px;
        }

        .auth-alert {
            background: #fbeaea;
            border: 1px solid #e3b3b3;
            color: #8a2f2f;
            padding: 14px 16px;
            font-size: 13.5px;
            margin-bottom: 22px;
        }

        .auth-alert strong {
            display: block;
            margin-bottom: 6px;
        }

        .auth-alert ul {
            list-style: disc;
            padding-left: 18px;
        }

        .field-error {
            display: block;
            color: #c0392b;
            font-size: 12px;
            margin-top: 6px;
            font-weight: 600;
        }

        .form-row input.is-invalid,
        .form-row select.is-invalid {
            border-color: #c0392b;
            background: #fff6f6;
        }

        .nat-toggle {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 4px;
        }

        .nat-option {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1.5px solid var(--line);
            padding: 11px 12px;
            font-size: 13px;
            color: var(--ink-soft);
            cursor: pointer;
            font-weight: 600;
        }

        .nat-option:has(input:checked) {
            border-color: var(--forest-mid);
            background: var(--water-soft);
            color: var(--forest-deep);
        }

        .nat-option input {
            flex-shrink: 0;
        }

        .form-row {
            margin-bottom: 18px;
        }

        .form-row-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-row-split--phone {
            grid-template-columns: .55fr 1fr;
        }

        .form-row label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 7px;
        }

        .form-row input[type="text"],
        .form-row input[type="email"],
        .form-row input[type="tel"],
        .form-row input[type="date"],
        .form-row input[type="password"],
        .form-row select {
            width: 100%;
            border: 1.5px solid var(--line);
            padding: 12px 14px;
            font-size: 14px;
            font-family: inherit;
            background: var(--paper);
            border-radius: 2px;
        }

        .form-row input:focus,
        .form-row select:focus {
            outline: none;
            border-color: var(--forest-mid);
            background: var(--white);
        }

        .checkbox-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: var(--ink-soft);
            margin: 22px 0 24px;
            cursor: pointer;
        }

        .checkbox-row input {
            margin-top: 3px;
            flex-shrink: 0;
        }

        .checkbox-row a {
            color: var(--forest-mid);
            font-weight: 600;
            text-decoration: underline;
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 26px 0;
            color: var(--ink-soft);
            font-size: 12.5px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--line);
        }

        @media (max-width: 900px) {
            .auth-grid {
                grid-template-columns: 1fr;
            }

            .auth-side,
            .auth-card {
                padding: 36px 28px;
            }

            .form-row-split,
            .form-row-split--phone,
            .nat-toggle {
                grid-template-columns: 1fr;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        (function() {
            var radios = document.querySelectorAll('input[name="nationalite_type"]');
            var rowPays = document.getElementById('rowPaysNationalite');
            var pieceType = document.getElementById('piece_type');
            var labelPieceNumero = document.getElementById('labelPieceNumero');
            var paysResidence = document.getElementById('pays_residence');

            function syncNationalite() {
                var value = document.querySelector('input[name="nationalite_type"]:checked').value;
                var isInternational = value === 'internationale';

                rowPays.style.display = isInternational ? 'block' : 'none';
                document.getElementById('pays_nationalite').required = isInternational;

                if (isInternational) {
                    pieceType.value = 'passeport';
                    if (paysResidence.value === 'Burkina Faso') {
                        paysResidence.value = '';
                    }
                } else {
                    pieceType.value = 'cnib';
                    if (!paysResidence.value) {
                        paysResidence.value = 'Burkina Faso';
                    }
                }
                syncPieceLabel();
            }

            function syncPieceLabel() {
                labelPieceNumero.textContent = pieceType.value === 'cnib' ? 'Numéro CNIB' : 'Numéro de passeport';
            }

            radios.forEach(function(r) {
                r.addEventListener('change', syncNationalite);
            });
            pieceType.addEventListener('change', syncPieceLabel);

            syncNationalite();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views\auth\inscription.blade.php ENDPATH**/ ?>