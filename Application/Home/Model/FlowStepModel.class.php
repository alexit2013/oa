<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FlowStep
 *
 * @author jiajun
 */
namespace Home\Model;
use Think\Model;
class FlowStepModel extends Model{
    public function get_tag_list($flowid) {
		$where['flow_type_id'] = $flowid;
		$list = M("flow_step") -> where($where) -> order('sort asc') -> field('id,name')->select();
		return $list;
	}

    public function get_data_list($controller = CONTROLLER_NAME, $tag_id = null) {
            $model = M("SystemTagData");
            $where = "tag.controller='$controller'";
            if (!empty($tag_id)) {
                    $where .= " and tag_id=$tag_id";
            }
            $join = 'join ' . $this -> tablePrefix . 'system_tag tag on tag_id=tag.id';
            $list = $model -> join($join) -> where($where) -> field("row_id,tag_id") -> select();
            return $list;
    }
}
