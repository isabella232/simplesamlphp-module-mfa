<?php
$this->data['header'] = 'Last Printable Backup Code';
$this->includeAtTemplateBase('includes/header.php');

$hasOtherMfaOptions = $this->data['hasOtherMfaOptions'];
?>
<p>
    You just used your last Printable Backup Code.
</p>

<?php if (! $hasOtherMfaOptions): ?>
    <p>
      Since you do not have any other 2-Step Verification options set up yet,
      you need to get more Printable Backup Codes now so that you will have some
      next time we ask you for one.
    </p>
<?php endif; ?>

<form method="post">
    <button name="setUpMfa" style="padding: 4px 8px;">
        Get more
    </button>
    
    <?php if ($hasOtherMfaOptions): ?>
        <button name="continue" style="padding: 4px 8px;">
            Remind me later
        </button>
    <?php endif; ?>
</form>
<?php
$this->includeAtTemplateBase('includes/footer.php');