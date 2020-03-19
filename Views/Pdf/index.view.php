<script src="<?=Config::get('host')?>/root/MDB/pspdfkit/pspdfkit.js" type="text/javascript"></script>
<p>PDF Editing page</p>

<!--License Key: OLod_HY1aKfZVuAjfjhIqXTPbz0sL972Xd-CY8VSK_SbEcSz7
_dXvjb1Rj2twyG7z22ZsOmW-Jnc2f3bDExl2odg3ShZxm7AiNvFQe5o8YZPL-tGLi8c4yLUPvC5yomX4A9TAMBr1D-
g80u2tyiXdcI4rGdx0jGr78TawRg148tIE5qzbv5wUEFzsA9MG9f9nbDxIFyFnDWLiYg8Dq_
BifHvdMeAxk1vpVCpyN3B_sok3c_RTOMSGAnMnMI0rF0Q_Koc4TPVH0XPRw30yF523IkTtaJajBcQ9qT
_rfeg1pTWDy7bhq6YWB7cxW5oe2oqqbMsXK3My4pgz9T5lL-B6JVDz3MEc8oCOPL7lJil8_e_K0gg_fOWsWVNaE1QjADllitpv6JcHmy7j9T0yQmknUwnUsSJW73Lx6RZ9pT6AT6zvrnPEaUpD2OK40oecRs5-->

<!-- 2. Element where PSPDFKit will be mounted. -->
<div id="pspdfkit" style="width: 100%; height: 480px;"></div>

<!-- 3. Initialize PSPDFKit. -->
<script>
  
  PSPDFKit.load({
    container: "#pspdfkit",
    pdf: "<?=Config::get('host')?>/root/MDB/pspdfkit/pspdfkit-lib/voucher.pdf",
    licenseKey: "OLod_HY1aKfZVuAjfjhIqXTPbz0sL972Xd-CY8VSK_SbEcSz7_dXvjb1Rj2twyG7z22ZsOmW-Jnc2f3bDExl2odg3ShZxm7AiNvFQe5o8YZPL-tGLi8c4yLUPvC5yomX4A9TAMBr1D-g80u2tyiXdcI4rGdx0jGr78TawRg148tIE5qzbv5wUEFzsA9MG9f9nbDxIFyFnDWLiYg8Dq_BifHvdMeAxk1vpVCpyN3B_sok3c_RTOMSGAnMnMI0rF0Q_Koc4TPVH0XPRw30yF523IkTtaJajBcQ9qT_rfeg1pTWDy7bhq6YWB7cxW5oe2oqqbMsXK3My4pgz9T5lL-B6JVDz3MEc8oCOPL7lJil8_e_K0gg_fOWsWVNaE1QjADllitpv6JcHmy7j9T0yQmknUwnUsSJW73Lx6RZ9pT6AT6zvrnPEaUpD2OK40oecRs5"
  })
    .then(function(instance) {
      console.log("PSPDFKit loaded", instance);
    })
    .catch(function(error) {
      console.error(error.message);
    });
</script>