$(function() {
    $('.btn-danger').on('click', function(event){
        event.preventDefault();
        var deleteConfirm = confirm('削除してよろしいでしょうか？');
        if(deleteConfirm == true) {
            console.log('削除非同期開始');
            var clickEle = $(this);
            var productId = clickEle.attr('data-product_id');
            var deleteTarget = clickEle.closest('tr');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                url: "/product/public/products/" + productId,
                dataType: 'json',
                data: {'id': productId}
                      
            })
            .done(function() {
                console.log('削除通信成功');
                deleteTarget.remove();
                // window.location.href = '/products';
                
            })
            .fail(function() {
                console.log('通信後失敗');
            });
        }
    });
});
