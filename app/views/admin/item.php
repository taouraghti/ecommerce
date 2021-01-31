<h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Category</td>
                        <td>Username</td>
                        <td>Adding Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                        foreach($data as $row)
                        {
                            echo"<tr>";
                            echo '<td>' .$row["ItemID"]. '</td>';
                            echo '<td>' .$row["Name"]. '</td>';
                            echo '<td>' .$row["Description"]. '</td>';
                            echo '<td>' .$row["Price"]. '</td>';
                            echo '<td>' .$row["CatName"]. '</td>';
                            echo '<td>' .$row["Username"]. '</td>';
                            echo '<td>' .$row["AddDate"]. '</td>';
                            echo '<td>
                                <a href="items.php?do=edit&itemid=1" class="btn btn-outline-success"><i class="fa fa-edit"></i> Edit</a>
                                <a href="items.php?do=delete&itemid=1" class="btn btn-outline-danger confirm"><i class="fas fa-times"></i> Delete</a>';
                                if($row['Approve'] == 0)
                                    echo '<a href="items.php?do=approve&itemid=1" class="btn btn-outline-primary activate-btn"><i class="fas fa-check"></i>Approve</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </table>
            </div>
            <a href="?do=add" class="btn btn-primary"><i class="fa fa-plus"></i> New Items</a>
        </div>