<?php
$this->data['header'] = '2-Step Verification';
$this->includeAtTemplateBase('includes/header.php');
?>
<script src="<?=SimpleSAML\Module::getModuleURL('mfa/u2f-api.js');?>"></script>
<script type="application/javascript">
    window.onload = function() {

      console.log('data:');
      console.log(<?=json_encode($this->data)?>);

      var mfa = <?php echo json_encode($this->data['mfaOption']['data'], JSON_PRETTY_PRINT);?>;
      console.log(mfa);
      u2f.sign(mfa.appId, mfa.challenge, [mfa], function(response) {
        console.log(response);
        if (response.errorCode && response.errorCode != 0) {
          alert("Error from U2F, code: " + response.errorCode);
          return;
        }
        var mfaForm = document.getElementById('mfaForm');
        var mfaResponse = document.getElementById('mfaSubmission');
        mfaResponse.value = JSON.stringify(response);
        mfaForm.submit();
      });
    }
</script>
<form method="post">
    <h2>USB Security Key</h2>
    <p id="mfaInstructions">Please insert your security key and press its button.</p>
    <p>
        <input type="checkbox" name="rememberMe" id="rememberMe" value="true" checked="checked"/>
        <label for="rememberMe">Remember this computer for 30 days</label>
        <br />
        <input type="hidden" id="mfaSubmission" name="mfaSubmission" />
        <input type="hidden" id="submitMfa" name="submitMfa" />

    </p>

    <?php if (count($this->data['mfaOptions']) > 1): ?>
        <p>
            Don't have your security key handy? You may also use:
        </p>
        <ul>
            <?php
            foreach ($this->data['mfaOptions'] as $mfaOpt) {
                if ($mfaOpt['type'] != 'u2f') {
                    ?>
                    <li><a href="prompt-for-mfa.php?StateId=<?= htmlentities($this->data['stateId']) ?>&mfaId=<?= htmlentities($mfaOpt['id']) ?>"><?=
                       htmlentities($mfaOpt['type'])
                    ?></a></li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php endif; ?>
</form>
<?php
$this->includeAtTemplateBase('includes/footer.php');
