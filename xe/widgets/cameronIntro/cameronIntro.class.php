<?php
    /**
     * @class cameronIntro
     * @author CAMERON (mail@cameron.co.kr)
     **/

	class cameronIntro extends WidgetHandler {
		function proc($args) {
			// 세로사이즈
			$args->cheight = $args->cheight;
			// 컨텐츠1
			$args->c1_title = $args->c1_title;
			$args->c1_desc = $args->c1_desc;
			$args->c1_image = $args->c1_image;
			$args->c1_icon = $args->c1_icon;
			$args->c1_iconsize = $args->c1_iconsize;
			$args->c1_color = $args->c1_color;
			$args->c1_link = $args->c1_link;
			if(!$args->c1_link) $args->c1_link = '#';
			$args->c1_blank = $args->c1_blank;
			if(!$args->c1_blank) $args->c1_blank = 'self';
			// 컨텐츠2
			$args->c2_title = $args->c2_title;
			$args->c2_desc = $args->c2_desc;
			$args->c2_image = $args->c2_image;
			$args->c2_icon = $args->c2_icon;
			$args->c2_iconsize = $args->c2_iconsize;
			$args->c2_color = $args->c2_color;
			$args->c2_link = $args->c2_link;
			if(!$args->c2_link) $args->c2_link = '#';
			$args->c2_blank = $args->c2_blank;
			if(!$args->c2_blank) $args->c2_blank = 'self';
			// 컨텐츠3
			$args->c3_title = $args->c3_title;
			$args->c3_desc = $args->c3_desc;
			$args->c3_image = $args->c3_image;
			$args->c3_icon = $args->c3_icon;
			$args->c3_iconsize = $args->c3_iconsize;
			$args->c3_color = $args->c3_color;
			$args->c3_link = $args->c3_link;
			if(!$args->c3_link) $args->c3_link = '#';
			$args->c3_blank = $args->c3_blank;
			if(!$args->c3_blank) $args->c3_blank = 'self';
			// 컨텐츠4
			$args->c4_title = $args->c4_title;
			$args->c4_desc = $args->c4_desc;
			$args->c4_image = $args->c4_image;
			$args->c4_icon = $args->c4_icon;
			$args->c4_iconsize = $args->c4_iconsize;
			$args->c4_color = $args->c4_color;
			$args->c4_link = $args->c4_link;
			if(!$args->c4_link) $args->c4_link = '#';
			$args->c4_blank = $args->c4_blank;
			if(!$args->c4_blank) $args->c4_blank = 'self';
	
			$output = $this->_compile($args,$content_items);
			return $output;
	
		}
	
		function _compile($args,$content_items){
			$oTemplate = &TemplateHandler::getInstance();
	
			// 위젯에 넘기기 위한 변수 설정
			$widget_info->cs = $args->cs;
			$widget_info->cheight = $args->cheight;
			//컨텐츠1
			$widget_info->c1_title = $args->c1_title;
			$widget_info->c1_desc = $args->c1_desc;
			$widget_info->c1_image = $args->c1_image;
			$widget_info->c1_icon = $args->c1_icon;
			$widget_info->c1_iconsize = $args->c1_iconsize;
			$widget_info->c1_color = $args->c1_color;
			$widget_info->c1_link = $args->c1_link;
			$widget_info->c1_blank = $args->c1_blank;
			//컨텐츠2
			$widget_info->c2_title = $args->c2_title;
			$widget_info->c2_desc = $args->c2_desc;
			$widget_info->c2_image = $args->c2_image;
			$widget_info->c2_icon = $args->c2_icon;
			$widget_info->c2_iconsize = $args->c2_iconsize;
			$widget_info->c2_color = $args->c2_color;
			$widget_info->c2_link = $args->c2_link;
			$widget_info->c2_blank = $args->c2_blank;
			//컨텐츠3
			$widget_info->c3_title = $args->c3_title;
			$widget_info->c3_desc = $args->c3_desc;
			$widget_info->c3_image = $args->c3_image;
			$widget_info->c3_icon = $args->c3_icon;
			$widget_info->c3_iconsize = $args->c3_iconsize;
			$widget_info->c3_color = $args->c3_color;
			$widget_info->c3_link = $args->c3_link;
			$widget_info->c3_blank = $args->c3_blank;
			//컨텐츠4
			$widget_info->c4_title = $args->c4_title;
			$widget_info->c4_desc = $args->c4_desc;
			$widget_info->c4_image = $args->c4_image;
			$widget_info->c4_icon = $args->c4_icon;
			$widget_info->c4_iconsize = $args->c4_iconsize;
			$widget_info->c4_color = $args->c4_color;
			$widget_info->c4_link = $args->c4_link;
			$widget_info->c4_blank = $args->c4_blank;
	
			Context::set('colorset', $args->colorset);
			Context::set('widget_info', $widget_info);
	
			$tpl_path = sprintf('%sskins/%s', $this->widget_path, $args->skin);
			return $oTemplate->compile($tpl_path, "content");
		}
	}
?>
