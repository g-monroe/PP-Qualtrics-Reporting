/*=========================================================================================
    File Name: tree-view.js
    Description: Bootstrap Tree View
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function(){



    // Check / Uncheck All
    var $checkableTree = $('#checkable-tree').treeview({
        data: defaultData,
        showIcon: false,
        showCheckbox: true,
    });
    // Check / Uncheck All
    var $elementsTree = $('#elements-treeview').treeview({
        data: elementsData,
        showIcon: false,
    });
    // Check/uncheck all
    $('#btn-check-all').on('click', function(e) {
        $checkableTree.treeview('checkAll', {
            silent: $('#chk-check-silent').is(':checked')
        });
    });

    $('#btn-uncheck-all').on('click', function(e) {
        $checkableTree.treeview('uncheckAll', {
            silent: $('#chk-check-silent').is(':checked')
        });
    });
});
