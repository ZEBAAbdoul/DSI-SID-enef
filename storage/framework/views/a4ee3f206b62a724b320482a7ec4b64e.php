<?php $__env->startSection('title', 'Contact — ENEF'); ?>

<?php $__env->startSection('content'); ?>

<section style="padding:76px 0;">
    <div class="container">
        <div class="section-head" style="margin-bottom:42px;">
            <div>
                <span class="kicker">Contact</span>
                <h2>Écrivez-nous à l'ENEF</h2>
                <p class="desc">Une question sur nos formations, les admissions ou un autre sujet ?
                    Remplissez le formulaire, nous vous répondrons dans les plus brefs délais.</p>
            </div>
        </div>

        <?php if(session('success')): ?>
        <div class="cflash cflash-ok">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
        <div class="cflash cflash-err">
            <?php echo e(session('error')); ?>

        </div>
        <?php endif; ?>

        <div class="contact-grid">
            <div class="contact-info">
                <div class="ci-card">
                    <span class="ci-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                    </span>
                    <div>
                        <h4>Adresse</h4>
                        <p><?php echo e($param_site->adresse ?? '01 BP 1105, Dindéresso — Bobo-Dioulasso, Burkina Faso'); ?></p>
                    </div>
                </div>

                <div class="ci-card">
                    <span class="ci-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.34 1.79.66 2.65a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.43-1.27a2 2 0 0 1 2.11-.45c.86.32 1.75.54 2.65.66A2 2 0 0 1 22 16.92z" />
                        </svg>
                    </span>
                    <div>
                        <h4>Téléphone</h4>
                        <p><?php echo e($param_site->telephone ?? '(00226) 20 98 06 89'); ?></p>
                    </div>
                </div>

                <div class="ci-card">
                    <span class="ci-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="m22 7-10 6L2 7" />
                        </svg>
                    </span>
                    <div>
                        <h4>Email</h4>
                        <p><?php echo e($param_site->email_contact ?? 'infos@enef.gov.bf'); ?></p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <form method="POST" action="<?php echo e(route('contact.send')); ?>" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="field">
                            <label for="nom">Nom complet <span>*</span></label>
                            <input type="text" id="nom" name="nom" value="<?php echo e(old('nom')); ?>"
                                placeholder="Votre nom et prénom" required autocomplete="name">
                            <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="err"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="field">
                            <label for="email">Adresse email <span>*</span></label>
                            <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>"
                                placeholder="vous@exemple.com" required autocomplete="email">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="err"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="field">
                            <label for="telephone">Téléphone <span class="opt">(optionnel)</span></label>
                            <input type="tel" id="telephone" name="telephone" value="<?php echo e(old('telephone')); ?>"
                                autocomplete="tel">
                            <?php $__errorArgs = ['telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="err"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="field">
                            <label for="sujet">Sujet <span>*</span></label>
                            <input type="text" id="sujet" name="sujet" value="<?php echo e(old('sujet')); ?>"
                                placeholder="Objet de votre message" required>
                            <?php $__errorArgs = ['sujet'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="err"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="field">
                        <label for="message">Message <span>*</span></label>
                        <textarea id="message" name="message" rows="7" placeholder="Votre message..."
                            required><?php echo e(old('message')); ?></textarea>
                        <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="err"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="field">
                        <label for="math_answer"><?php echo e($math['a']); ?> + <?php echo e($math['b']); ?> = ? <span>*</span></label>
                        <input type="text" id="math_answer" name="math_answer" inputmode="numeric" autocomplete="off"
                            placeholder="?" value="<?php echo e(old('math_answer')); ?>" required>
                        <?php $__errorArgs = ['math_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><small class="err"><?php echo e($message); ?></small><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="hp-field" aria-hidden="true">
                        <label for="website">Ne renseignez pas ce champ</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                        <input type="hidden" name="honeypot_time" value="<?php echo e(time()); ?>">
                    </div>

                    <button type="submit" id="btn-envoyer" class="btn btn-primary" disabled>Envoyer le message</button>
                    <small class="gating-hint">Résolvez le calcul pour activer l'envoi.</small>
                </form>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    (function () {
        var a = <?php echo e((int) $math['a']); ?>;
        var b = <?php echo e((int) $math['b']); ?>;
        var total = a + b;
        var input = document.getElementById('math_answer');
        var btn = document.getElementById('btn-envoyer');

        if (!input || !btn) return;

        function verifier() {
            var val = input.value.replace(/\s+/g, '');
            var ok = val !== '' && String(total) === val;
            btn.disabled = !ok;
        }

        input.addEventListener('input', verifier);
        verifier();
    })();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .contact-grid {
        display: grid;
        grid-template-columns: 380px 1fr;
        gap: 48px;
        align-items: start;
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .ci-card {
        display: flex;
        gap: 16px;
        align-items: flex-start;
        background: var(--white);
        border: 1px solid #e6e3df;
        padding: 18px 20px;
        border-radius: 6px;
    }

    .ci-icon {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        border-radius: 50%;
        background: rgba(35, 88, 112, .12);
        color: var(--water);
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .ci-icon svg {
        width: 18px;
        height: 18px;
    }

    .ci-card h4 {
        margin: 0 0 4px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: var(--forest-deep);
    }

    .ci-card p {
        margin: 0;
        font-size: 15px;
        color: var(--ink-soft);
    }

    .ci-note {
        background: var(--forest-deep);
        color: #fff;
        border-radius: 6px;
        padding: 20px 22px;
    }

    .ci-note h4 {
        margin: 0 0 8px;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .ci-note p {
        margin: 2px 0;
        font-size: 14px;
        color: #cfdbc9;
    }

    .contact-form {
        background: var(--white);
        border: 1px solid #e6e3df;
        border-radius: 8px;
        padding: 32px;
        box-shadow: 0 14px 40px rgba(27, 39, 30, .07);
    }

    .contact-form .row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 18px;
    }

    .field label {
        font-size: 13.5px;
        font-weight: 700;
        color: var(--forest-deep);
    }

    .field label span {
        color: var(--clay);
    }

    .field label span.opt {
        color: var(--ink-soft);
        font-weight: 400;
        font-size: 12.5px;
    }

    .field input,
    .field textarea {
        width: 100%;
        border: 1.5px solid #e0dcd7;
        border-radius: 5px;
        padding: 12px 14px;
        font-size: 15px;
        font-family: inherit;
        color: var(--ink);
        background: #fff;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .field input:focus,
    .field textarea:focus {
        outline: none;
        border-color: var(--water);
        box-shadow: 0 0 0 3px rgba(35, 88, 112, .12);
    }

    .field textarea {
        resize: vertical;
        min-height: 140px;
    }

    .err {
        color: #c0392b;
        font-size: 12.5px;
        font-weight: 600;
    }

    .cbox {
        margin: 4px 0 22px;
    }

    .hp-field {
        position: absolute !important;
        left: -9999px !important;
        top: auto !important;
        width: 1px !important;
        height: 1px !important;
        overflow: hidden !important;
    }

    #btn-envoyer:disabled,
    #btn-envoyer[disabled] {
        opacity: .5;
        cursor: not-allowed;
    }

    .gating-hint {
        display: block;
        margin-top: 10px;
        font-size: 12.5px;
        color: var(--ink-soft);
    }

    .cflash {
        border-radius: 6px;
        padding: 14px 18px;
        font-size: 14.5px;
        margin-bottom: 20px;
        border: 1px solid transparent;
    }

    .cflash-ok {
        background: #edf7ee;
        border-color: #bfe3c0;
        color: #2e7d32;
    }

    .cflash-err {
        background: #fdf0ee;
        border-color: #f2c4bd;
        color: #b03525;
    }

    .cflash-warn {
        background: #fdf6e7;
        border-color: #ecd9a8;
        color: #8a6d1c;
    }

    .cflash-warn code {
        background: rgba(0, 0, 0, .05);
        padding: 1px 5px;
        border-radius: 3px;
        font-size: 13px;
    }

    @media (max-width: 960px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }

        .contact-form .row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.site', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\HP\Desktop\ENEF\enefApp\resources\views/contact/index.blade.php ENDPATH**/ ?>