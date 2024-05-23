$(function() {
  $('#search-form').submit(function(event) {
    event.preventDefault();
    
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: "http://localhost:8888/product/public/products/search", 
      type: 'GET',
      dataType: "json",
      data: {
        search: $('#search').val(),
        company_id: $('#company').val(),
        priceMin: $('input[name="price_min"]').val(),
        priceMax: $('input[name="price_max"]').val(),
        stockMin: $('input[name="stock_min"]').val(),
        stockMax: $('input[name="stock_max"]').val(),
      }
    }).done((response) => {
        console.log(response);
        var $result  = $('#search-results');
        $result.empty();
        $.each(response.products, function(index, product){
          var productId = product.id;
          var html = `
          <tr>
              <td>${product.product_name}</td>
              <td>${product.company_name}</td>
              <td>${product.price}</td>
              <td>${product.stock}</td>
              <td>${product.comment}</td>
              <td><img src="${product.img_path}" alt="商品画像" width="100"></td>
              <td>
                  <a href="/product/public/products/${productId}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                  <a href="/product/public/products/${productId}/edit" class="btn btn-primary btn-sm mx-1">編集</a>
                  <form method="POST" action="/product/public/products/${productId}" class="d-inline">
                      <input type="hidden" name="_token" value="${csrfToken}">
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" id="deletebtn" class="btn btn-danger btn-sm mx-1">削除</button>
                  </form>
              </td>
          </tr>`;
          $result.append(html);
      });
      }).fail((error) => {
        console.log('AJAXが失敗しました');
      });
    });
  });
