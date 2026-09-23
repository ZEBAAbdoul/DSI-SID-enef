<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name')); ?></title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f5; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
        style="background-color:#f4f4f5; padding: 30px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="background-color:#ffffff; border-radius:8px; overflow:hidden;">
                    <tr>
                        <td style="background-color:#2e7d32; padding: 24px; text-align:center;">
                            <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="ENEF" style="max-height:80px;">
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="margin-top:0; color:#1a1a1a;"><?php echo e($greeting); ?></h2>

                            <?php $__currentLoopData = $lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p style="color:#333333; font-size:15px; line-height:1.6;"><?php echo e($line); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php if(isset($actionText) && isset($actionUrl)): ?>
                                <table role="presentation" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
                                    <tr>
                                        <td style="border-radius:6px; background-color:#2e7d32;">
                                            <a href="<?php echo e($actionUrl); ?>" target="_blank"
                                                style="display:inline-block; padding:12px 28px; color:#ffffff; text-decoration:none; font-weight:bold; border-radius:6px;"><?php echo e($actionText); ?></a>
                                        </td>
                                    </tr>
                                </table>
                            <?php endif; ?>

                            <p style="color:#333333; font-size:15px;"><?php echo e($salutation ?? "Cordialement, l'équipe ENEF"); ?>

                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="background-color:#2e7d32; padding:20px; text-align:center; font-size:12px; color:#ffffff;">
                            <?php echo e(date('Y')); ?> ENEF. Tous droits réservés.<br>
                            École Nationale des Eaux et Forêts — Burkina Faso
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
<?php /**PATH C:\wamp64\www\Les projets finis\ENEF\resources\views/emails/notification.blade.php ENDPATH**/ ?>