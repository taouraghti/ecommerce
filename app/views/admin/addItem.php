
<h1 class="text-center">Add New Items</h1>
<div class="container">
    <form action="?do=insert" method="POST">
        <!--  Start Field Name  -->
        <div class="form-group row">
            <label class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" class="form-control" name="name" placeholder="Name Of The Item" required = "required">
            </div>
        </div> 
        <!--  End Field Name  -->

        <!--  Start Field Description  -->
        <div class="form-group row">
            <label class="col-sm-2 control-label">Description</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" class="form-control" name="description" placeholder="Description Of The Item" required = "required">
            </div>
        </div> 
        <!--  End Field Description  -->

        <!--  Start Field Price  -->
        <div class="form-group row">
            <label class="col-sm-2 control-label">Price</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" class="form-control" name="price" placeholder="Price Of The Item" required = "required">
            </div>
        </div> 
        <!--  End Field Price  -->

        <!--  Start Field CountryMade  -->
        <div class="form-group row">
            <label class="col-sm-2 control-label">Country</label>
            <div class="col-sm-10 col-md-6">
                <input type="text" class="form-control" name="country" placeholder="Country of Made">
            </div>
        </div> 
        <!--  End Field CountryMade  -->

        <!--  Start Field Status  -->
        <div class="form-group row">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-10 col-md-6">
                <select class="form-control" name="status">
                    <option value="0">...</option>
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Old</option>
                </select>
            </div>
        </div> 
        <!--  End Field status  -->

        <!--  Start Field Members  -->
        <div class="form-group row">
            <label class="col-sm-2 control-label">Member</label>
            <div class="col-sm-10 col-md-6">
                <select class="form-control" name="member">
                    <option value="0">...</option>
                    <?php
                        $stmt = $con->prepare("SELECT * FROM users");
                        $stmt->execute();
                        $row = $stmt->fetchAll();
                        foreach($row as $r)
                        {
                            echo  '<option value="'.$r['UserID'].'">'.$r['Username'].'</option>';
                        }
                    ?>
                </select>
            </div>
        </div> 
        <!--  End Field Members  -->

        <!--  Start Field Categories  -->
        <div class="form-group row">
            <label class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10 col-md-6">
                <select class="form-control" name="category">
                    <option value="0">...</option>
                    <?php
                        $stmt = $con->prepare("SELECT * FROM categories");
                        $stmt->execute();
                        $row = $stmt->fetchAll();
                        foreach($row as $r)
                        {
                            echo  '<option value="'.$r['ID'].'">'.$r['Name'].'</option>';
                        }
                    ?>
                </select>
            </div>
        </div> 
        <!--  End Field Members  -->

        <!--  Start Field Submit  -->
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <input type="submit" class="btn btn-success" value="Add Item">
            </div>
        </div> 
        <!--  End Field Submit  -->   
    </form>
</div>