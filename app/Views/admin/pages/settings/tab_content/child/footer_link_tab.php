
<div class="row">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center" scope="col">Title</th>
                <th class="text-center" scope="col">Url Slug</th>
                <th class="text-center" scope="col"></th>
            </tr>
        </thead>
        <tbody class="tb-rows">
            <?php
                $footer_link_field = 'footer_links['. $lang_code .']';
            ?>
            <?php if (!empty($footer_links)) : ?>
                <?php foreach ($footer_links as $key => $item_row) :?>
                    <tr class="tb-row" data-number="<?=esc($key);?>">
                        <td class="w-30p">
                            <input type="text" name="<?= esc($footer_link_field) ?>[<?= esc($key)?>][title]" value="<?=sanitize_output($item_row['title'])?>" class="form-control"  placeholder="Enter a title for the footer link...">
                            <div class="invalid-feedback"></div>
                        </td>
                        <td>
                            <input type="text" name="<?= esc($footer_link_field) ?>[<?= esc($key)?>][url_slug]" value="<?=sanitize_output($item_row['url_slug'])?>" class="form-control" placeholder="Enter a URL slug (use hyphens instead of spaces)">
                            <div class="invalid-feedback"></div>
                        </td>
                        <td class="text-center w-10p"><span class="btn btn-outline-danger btn-sm btnRemoveItem" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fe fe-trash-2"></i></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr class="tb-row btn-add-item-area text-right">
                <td colspan="3"><span class="btn btn-outline-info btn-sm btnAddItem"><i class="fe fe-plus-square"></i> Add item</span></td>
            </tr>
            <tr class="tb-row-more d-none tb-row" data-number="__number__">
                <td>
                    <input type="text" __name__="<?= esc($footer_link_field) ?>[__number__][title]" placeholder="Enter a title for the footer link..." class="form-control">
                    <div class="invalid-feedback"></div>
                </td>
                <td>
                    <input type="text" __name__="<?= esc($footer_link_field) ?>[__number__][url_slug]" placeholder="Enter a URL slug (use hyphens instead of spaces)" class="form-control">
                    <div class="invalid-feedback"></div>
                </td>
                <td class="text-center w-10p"><span class="btn btn-outline-danger btn-sm btnRemoveItem" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fe fe-trash-2"></i></span></td>
            </tr>
        </tbody>
    </table>
</div>



