$(document).on('click', 'i.actUpdateComment', function(){
    var action = $(this).text();
    var target = $(this).closest('tr').find('td:eq(2)');
    if (action === 'edit') {
        makeInput(target);
        $(this).text('publish');
    } else if (action === 'publish') {
        var tableComment = target.find('input').val();
        var tableName = $(this).closest('tr').find('td:eq(1)').html();
        result = publishExecute(tableName, tableComment);
        if (result === true) {
            target.html(tableComment);
            $(this).text('edit');
        } else {
            alert('冷たいけど修正失敗した');
        }
    }
});

$(document).on('click', 'i.actShowTableDetail', function(){
    var tableName = $(this).closest('tr').find('td:eq(1)').html();
    var url = 'show_table_detail.php?table_name=' +  tableName;
    window.open(url);
});

function makeInput(target) {
    var text =target.html();
    var inputHtml = '<input type="text" class="inputText" value="'
    + text
    + '" style="width:400px;">';
    target.html(inputHtml);
}

function publishExecute(tableName, tableComment) {
    data = {
        'tableName' : tableName,
        'tableComment' : tableComment,
    }
    var res = false;
    $.ajax({
        type    : 'post',
        url     : 'ajax/update_table_comment.php',
        async   : false,
        data    : data,
        dataType:'json',
        success : function(result){
            res = result.result;
        },
        error : function(result){
        }
    });
    return res;
}