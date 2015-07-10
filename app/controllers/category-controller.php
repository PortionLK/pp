<?php
    define('_MEXEC', 'OK');
    require_once("../../system/load.php");

    $action = $_REQUEST['action'];

    switch ($action) {

        case "viewCategory":
            viewCategory();
            break;
        case "addCategory":
            addCategory();
            break;
        case "updateCategory":
            updateCategory();
            break;
        case "deleteCategory":
            deleteCategory();
            break;
    }

    function viewCategory()
    {
        $category = new Category();
        $data = $category->getAllCategoryPaginated($_REQUEST['page']);

        $count = $category->getAllCategoryCount();

        viewTable($data, $count[0]['count']);

    }

    function addCategory()
    {

        $category = new Category();

        $category->setValues($_REQUEST);

        if ($category->newCategory()) {
            Common::jsonSuccess("Category Added Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function updateCategory()
    {

        $admin = new Category();

        $get_edited = array();

        foreach ($_REQUEST as $k => $v) {
            $get_edited[str_replace("edit_", "", $k)] = $v;
        }

        $admin->setValues($get_edited);

        if ($admin->updateCategory()) {
            Common::jsonSuccess("Category Update Successfully!");
        } else {
            Common::jsonError("Error");
        }

    }

    function deleteCategory()
    {

        $category = new Category();
        $category->setCategoryId($_REQUEST['id']);

        if ($category->deleteCategory()) {
            Common::jsonSuccess("Category Deleted Successfully");
        } else {
            Common::jsonError("Error");
        }

    }

    function viewTable($data, $count)
    {

        $category = new Category();

        $paginations = new Paginations();
        $paginations->setLimit(10);
        $paginations->setPage($_REQUEST['page']);
        $paginations->setJSCallback("viewCategory");
        $paginations->setTotalPages($count);
        $paginations->makePagination();


        ?>
        <div class="mws-panel-header">
            <span class="mws-i-24 i-table-1">View Category</span>
        </div>
        <div class="mws-panel-body">
            <table cellpadding="0" cellspacing="0" border="0" class="mws-datatable-fn mws-table">
                <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Category Seo Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (count($data) > 0) { ?>

                    <?php
                    for ($i = 0; $i < count($data); $i++) {
                        $category->extractor($data, $i);
                        ?>
                        <tr id="row_<?php echo $category->categoryId(); ?>">
                            <td><?php echo $category->categoryName(); ?></td>
                            <td><?php echo $category->categorySeoName(); ?></td>
                            <td class="center">
                                <a onclick="loadGUIContent('category','edit','<?php echo $category->categoryId(); ?>')"
                                   class="link_hand">Edit</a>
                                <a onclick="deleteCategory(<?php echo $category->categoryId(); ?>)" class="toggle"
                                   class="link_hand">Delete</a></td>
                        </tr>
                    <?php
                    }
                    ?>

                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php

        $paginations->drawPagination();

    }

?>