<?php
    /**
     * @author wiley (wiley@nurigo.net)
     **/

    class vanner extends WidgetHandler {
        function proc($widget_info) {
            // default
            if (!$widget_info->link_new_window) $widget_info->link_new_window='N';

            // 대상 모듈 (mid_list는 기존 위젯의 호환을 위해서 처리하는 루틴을 유지. module_srls로 위젯에서 변경)
            $oModuleModel = &getModel('module');
            if($widget_info->mid_list) {
                $mid_list = explode(",",$widget_info->mid_list);
                if(count($mid_list)) {
                    $module_srls = $oModuleModel->getModuleSrlByMid($mid_list);
                    if(count($module_srls)) $widget_info->module_srls = implode(',',$module_srls);
                    else $widget_info->module_srls = null;
                } 
            }

            // 정렬 대상
            $order_target = $widget_info->order_target;
            if(!in_array($order_target, array('list_order','update_order'))) $order_target = 'list_order';

            // 정렬 순서
            $order_type = $widget_info->order_type;
            if(!in_array($order_type, array('asc','desc'))) $order_type = 'asc';

            // 목록 수
            $list_count = (int)$widget_info->list_count;
            if(!$list_count) $list_count = 10;

            // 대상 모듈이 선택되어 있지 않으면 해당 사이트의 전체 모듈을 대상으로 함
            $site_module_info = Context::get('site_module_info');
            if($widget_info->module_srls) $obj->module_srl = $widget_info->module_srls;
            else if($site_module_info) $obj->site_srl = (int)$site_module_info->site_srl;

            // 게시물 가져오기
            $obj->sort_index = 'documents.'.$order_target;
            $obj->order_type = $order_type=="desc"?"asc":"desc";
            $obj->list_count = $list_count;
            $output = executeQueryArray('widgets.vanner.getDocuments', $obj);

            // document 모듈의 model 객체를 받아서 결과를 객체화 시킴
            $oDocumentModel = &getModel('document');

            // 오류가 생기면 그냥 무시
            if(!$output->toBool()) return;

            // 결과가 있으면 각 문서 객체화를 시킴
            if(count($output->data)) {
                $keys = array_keys($output->data);
                $ridx = mt_rand(0, count($keys)-1);
                $key = $keys[$ridx];
                $attribute = $output->data[$key];

                $oDocument = null;
                $oDocument = new documentItem();
                $oDocument->setAttribute($attribute, false);
            } else {
                $oDocument = new documentItem();
            }
            Context::set('document', $oDocument);


            $widget_info->thumbnail_width = $widget_info->thumbnail_width;
            $widget_info->thumbnail_height = $widget_info->thumbnail_height;
            $widget_info->thumbnail_type = $widget_info->thumbnail_type;
            Context::set('widget_info', $widget_info);

            // 템플릿의 스킨 경로를 지정 (skin, colorset에 따른 값을 설정)
            $tpl_path = sprintf('%sskins/%s', $this->widget_path, $widget_info->skin);
            Context::set('colorset', $widget_info->colorset);

            // 템플릿 파일을 지정
            $tpl_file = 'list';

            // 템플릿 컴파일
            $oTemplate = &TemplateHandler::getInstance();
            $output = $oTemplate->compile($tpl_path, $tpl_file);
            return $output;
        }
    }
?>
