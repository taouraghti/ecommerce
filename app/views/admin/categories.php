<h1 class="text-center">Manage Categories</h1>
        <div class="container category-container">
            <div class="card category">
                <div class="card-header">
                    <i class="fa fa-edit"></i> Manage Categories
                </div>
                <div class="card-body">
                    <?php
                        foreach($data as $cat)
                        {
                            echo '<div class="cat">';
                                echo '<div class="buttons-hidden">';
                                    echo '<a href="?do=edit&catid=1" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                                    echo '<a href="?do=delete&catid=1" class="btn btn-sm btn-danger confirm"><i class="fas fa-times"></i> Delete</a>';
                                echo '</div>';
                                echo '<h3>' . $cat['Name'] . "</h3>";
                                echo "<div class='full-view' style='display:none'>";
                                    echo "<p>"; if ($cat['Description'] == '') echo 'There is no Description'; else echo $cat['Description'];echo "</p>";
                                    if ($cat['Visibility'] == 1) echo'<span class="visibility"><i class="fas fa-eye"></i> Hidden</span>';
                                    if ($cat['Allow_Comment'] == 1) echo'<span class="comment"><i class="far fa-comment"></i> Comment Disabled</span>';
                                    if ($cat['Allow_Ads'] == 1) echo'<span class="ads"><i class="fas fa-times"></i> Ads Disabled</span>';
                                echo '</div>';
                            echo '</div>';
                            echo '<hr>';
                        }
                    ?>
                </div>
            </div>
            <a class="btn btn-info" href="?do=add"><i class="fa fa-plus"></i> New Category</a>
        </div>