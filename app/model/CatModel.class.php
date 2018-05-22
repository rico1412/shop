<?php
namespace model;  //创建了一个  全局空间 下的 model空间
use \core\Model;  //引入空间类

//创建了一个模型类
class CatModel extends Model{
	public function getCats(){
		$sql="select * from sp_category where 1";//构建查询SQL语句
		$categorys=$this->getRows($sql);//执行查询语句得到所有的费力数据
		//调用递归整理分类数据的方法,整理分类数据
		$tree=[];
		// var_dump($tree);die;
		$this->recursiveCat($tree,$categorys);
		return $tree;		
	}
	/**
	 * 递归整理分类数据
	 * @param $tree array 表示整理之后的分类数据集合
	 * @param $cats array 表示无序的所有分类数据的集合,也就是查询得到的所有分类数据
	 * @param $parent_id int 表示查询当前那个分类的子分类,比如$parent_id=0表示查询id为0分类的子分类
	 * @param $dir_tree 表示整理之后的分类数据前的分类图标个数,顶级分类的值为0
	 */
	protected function recursiveCat(&$tree,$cats,$parent_id=0,$dir_tree=0){
		foreach($cats as $cat){//当前遍历到的这条分类的子分类
			if($cat['parent_id']==$parent_id){
				$cat['dir_tree']=$dir_tree;
				$tree[]=$cat;
				$this->recursiveCat($tree,$cats,$cat['id'],$dir_tree+1);
			}
		}
	}
	
}