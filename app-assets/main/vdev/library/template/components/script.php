<?php
$HOMEURL= "https://rise.hs.iastate.edu/p-p";
$VERSION = "";
$ASSETS = "assets/";
$DASH = "";
$ROOT = $HOMEURL."/";
$APPASSETS = "app-assets/";
$full = $ROOT.$APPASSETS;
$fullAssets = $ROOT.$ASSETS;

?>
    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo($full); ?>vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="<?php echo($full); ?>vendors/js/forms/toggle/switchery.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/extensions/dragula.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/datatable/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/buttons.flash.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/jszip.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/pdfmake.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/editors/froala/js/froala_editor.min.js" type="text/javascript"></script>
    <!-- Include Code Mirror JS. -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>

    <!-- Include PDF export JS lib. -->
    <script type="text/javascript" src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="<?php echo($full); ?>vendors/js/editors/froala/js/froala_editor.pkgd.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/vfs_fonts.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/buttons.html5.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/tables/buttons.print.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/extensions/jquery.steps.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/pickers/dateTime/moment-with-locales.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/extensions/bootstrap-treeview.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/editors/quill/katex.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/editors/quill/highlight.min.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>vendors/js/editors/quill/quill.min.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="<?php echo($full); ?>js/core/app-menu.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>js/core/app.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>js/scripts/customizer.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?php echo($full); ?>js/scripts/forms/wizard-steps.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>js/scripts/tables/datatables/datatable-advanced.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
    <!-- BEGIN PAGE LEVEL JS-->
      <script src="<?php echo($full); ?>js/scripts/extensions/tree-view.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="<?php echo($full); ?>js/scripts/extensions/drag-drop.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
    <script src="<?php echo($full); ?>js/scripts/editors/editor-quill.js" type="text/javascript"></script>
    <script src="<?php echo($full); ?>js/scripts/forms/wizard-steps.js" type="text/javascript"></script>
