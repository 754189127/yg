
    <div id="content">
        <div class="form">
            <form id="login-form" action="/index.php/product/create" method="post">

              <table>
                  <tr>
                      <td>进货编号：</td>
                      <td> <input name="productCode" readonly="true" type="text" /></td>
                  </tr>
                  <tr>
                      <td>进货单id：</td>
                      <td> <input name="companyId" type="text" value="<?php echo $receiptId;?>" /></td>
                  </tr>
                  <tr>
                      <td>名称：</td>
                      <td> <input name="name" type="text" /></td>
                  </tr>
                  <tr>
                      <td>价格：</td>
                      <td> <input name="price" type="text" /></td>
                  </tr>
                  <tr>
                      <td>数量：</td>
                      <td> <input name="number" type="text" /></td>
                  </tr>
                  <tr>
                      <td>进价：</td>
                      <td> <input name="purchasePrice" type="text" /></td>
                  </tr>
                  <tr>
                      <td>包装形式：</td>
                      <td> <input name="bagShape" type="text" /></td>
                  </tr>
                  <tr>
                      <td>重量：</td>
                      <td> <input name="weight" type="text" /></td>
                  </tr>
                  <tr>
                      <td>备注：</td>
                      <td> <input name="remark" type="text" /></td>
                  </tr>
              </table>

                <div class="row buttons">
                    <input type="submit" name="yt0" value="提交" />	</div>
            </form></div><!-- form -->
    </div><!-- content -->

