<?php
    $xhtml = null;
    $tmplConfig   = config('AppConfig')->adminMenu;
    $currentController = (array_key_exists($controller_name, $tmplConfig)) ? $tmplConfig[$controller_name] : $tmplConfig['default'];
    $xhtmlPageRightOptions = null;
    if (isset($page_title['right']['type'])) {
        $classPageType = (isset($page_title) && $page_title['right']['action'] == 'ajaxModal') ? 'ajaxModal' : '';
        switch ($page_title['right']['type']) {
            case 'addButton':
                $link = (isset($page_title['right']['route-name'])) ? admin_url($controller_name . $page_title['right']['route-name']) : admin_url($controller_name . "/update");
                $name = (isset($page_title['right']['name'])) ? $page_title['right']['name'] : 'Add New';
                $xhtmlPageRightOptions = sprintf(
                    '<div class="col-md-3">
                        <div class="d-flex">
                            <a href="%s" class="ml-auto btn btn-outline-primary %s">
                                <span class="fe fe-plus"></span>
                                %s
                            </a>
                        </div>
                    </div>', $link, $classPageType, $name
                );
                break;
            case 'search':
                $show_search_area = show_search_area($controller_name, $params);
                $xhtmlPageRightOptions = sprintf(
                    '<div class="col-md-4">
                        <div class="search-area">
                            %s
                        </div>
                    </div>', $show_search_area
                );
                break;
        }
    }
    $xhtmlSecondRow = null;
    
    if (isset($page_title['secondRow'])) {
        $xhtmlSecondRowLeft = null;
        $xhtmlSecondRowRight = null;
        if (isset($page_title['secondRow']['left'])) {
            $xhtmlSecondRowLeft = '<div class="col-md-6"><div class="btn-group" role="group" aria-label="Basic example">';
            foreach ($page_title['secondRow']['left'] as $key => $row) {
                if (isset($row['route-name']) && $row['route-name'] !== '#') {
                    $link = admin_url($controller_name . $row['route-name']);
                } else {
                    $link = '#';
                }
                $xhtmlSecondRowLeft .= sprintf(
                    '<a href="%s" class="btn btn-outline-primary %s"><span class="%s"></span> %s</a>',
                    $link, $row['class'], $row['icon'], $row['name']
                );
            }
            $xhtmlSecondRowLeft .= '</div></div>';
        }

        if (isset($page_title['secondRow']['right'])) {
            $xhtmlSecondRowRight = '<div class="col-md-4 d-flex">';
            foreach ($page_title['secondRow']['right'] as $key => $row) {
                switch ($key) {
                    case 'sortBy':
                        $xhtmlSecondRowRight .= show_sort_by_on_page_tilte($controller_name, $items_by_category , $row);
                        break;
                        case 'bulkActions':
                            $xhtmlSecondRowRight .= show_bulk_actions($controller_name);
                        break;
                        case 'search':
                            $show_search_area = show_search_area($controller_name, $params);
                            $xhtmlSecondRowRight .= sprintf(
                                '<div class="search-area">
                                        %s
                                    </div>
                                ', $show_search_area
                            );
                        break;
                }
            }
            $xhtmlSecondRowRight .= '</div>';
        }
        $xhtmlSecondRow = sprintf(
            '<div class="col-md-12">
                <div class="row justify-content-between">
                    %s
                    %s
                </div>
            </div>', $xhtmlSecondRowLeft, $xhtmlSecondRowRight
        );
    }

    $xhtml = sprintf(
        '<div class="page-title m-b-20">
            <div class="row justify-content-between">
                <div class="col-md-3">
                    <h1 class="page-title">
                        <span class="%s"></span> %s
                    </h1>
                </div>
                %s
                %s
            </div>
        </div>', $currentController['icon'], $page_title['title'], $xhtmlPageRightOptions, $xhtmlSecondRow
    );
    echo $xhtml;
