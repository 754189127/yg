
    <div id="content">
        <div class="form">
            <form id="login-form" action="/index.php/receipt/create" method="post">

              <table>
                  <tr>
                      <td>ID</td>
                      <td>进货编号</td>
                      <td>厂商id</td>
                      <td>进货金额</td>
                      <td>进货日期</td>
                      <td>备注</td>
                      <td>操作</td>
                  </tr>
                  <?php foreach($list as $row){?>
                  <tr>
                      <td><?php echo $row['id']?></td>
                      <td><?php echo $row['receiptCode']?></td>
                      <td><?php echo $row['companyId']?></td>
                      <td><?php echo $row['purchaseAmount']?></td>
                      <td><?php echo $row['receiptDate']?></td>
                      <td><?php echo $row['remark']?></td>
                      <td><a href="/index.php/product/add/receiptId/<?php echo $row['id']?>">添加产品</a></td>
                  </tr>
                    <?php }?>
              </table>


            </form></div><!-- form -->
    </div><!-- content -->

