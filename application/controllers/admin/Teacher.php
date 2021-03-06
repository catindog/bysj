<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends MY_Controller {

	public function __construct()
    {
		parent::_constructAdmin();
		$this->load->model('Model_teacher', 'oTeacher');
		$this->load->model('Model_college', 'oCollege');
		$this->load->model('Model_special', 'oSpecial');
    }

	public function lists()
	{

		$this->load->library('pagination');
		$config = $this->config->item('app_page');
		$config['base_url'] = '/admin/teacher/lists';
		$config['total_rows'] = $this->oTeacher->count($this->input->get(null, true));
		$this->pagination->initialize($config);
		$page_link = $this->pagination->create_links();

		$aTeacher = $this->oTeacher->lists($this->input->get(null, true));

		$aSpecial = array();
		$aCollege = array();
		if ($aTeacher) {
			$aSpecial = array_column($this->oSpecial->top(array('spe_id'=>array_unique(array_filter(array_column($aTeacher, 'spe_id'))))), null, 'spe_id');
			$aCollege = array_column($this->oCollege->top(array('col_id'=>array_unique(array_filter(array_column($aTeacher, 'col_id'))))), null, 'col_id');
		}

		$this->assign('aTeacher', $aTeacher);
		$this->assign('aSpecial', $aSpecial);
		$this->assign('aCollege', $aCollege);
		$this->assign('page_links', $page_link);
		$this->assign('total_rows', $config['total_rows']);

		$this->display('admin/teacher_lists.html');
	}

	public function add()
	{
		
		if ($this->input->get('act') == 'do') {
			$aReceive = $this->input->post(null, true);

			$aResult = $this->oForm->formValidation('teacher_add', $aReceive);
			if ($aResult['code'] != 1) {
				$this->error($aResult['message']);
			}

			if ($this->oTeacher->get(array('code'=>$aReceive['code']))) {
				$this->error('编号已存在');
			}
			if ($this->oTeacher->get(array('card_id'=>$aReceive['card_id']))) {
				$this->error('身份证号已存在');
			}
			if ($this->oTeacher->get(array('email'=>$aReceive['email']))) {
				$this->error('邮箱已被使用');
			}
			
			$aReceive['password'] = substr($aReceive['card_id'], -6);
			$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
			$aReceive['salt'] = $chars[rand(0,35)].$chars[rand(0,35)].$chars[rand(0,35)].$chars[rand(0,35)];
			$aReceive['password'] = md5(md5($aReceive['password']).$aReceive['salt']);
			
			$aTeacher = $this->oTeacher->add($aReceive);
			if (!$aTeacher) {
				$this->error('添加失败');
			}

			$this->oLog->add(array('content'=>'添加教师账号['.$aTeacher.']'.$aReceive['name']));

			$this->success('添加成功');
		}

		$aCollege = $this->oCollege->top();

		$this->assign('aCollege', $aCollege);

		$this->display('admin/teacher_add.html');
    }
    
    public function delete()
	{
		
		if ($this->input->get('act') == 'do') {
            
            if (!$id = $this->input->post('tea_id', true)) {
                $this->error('参数错误');
			}

			$aTeacher = $this->oTeacher->delete(array('tea_id'=>$id));
			if (!$aTeacher) {
				$this->error('删除失败');
			}
			$this->success('删除成功');
		}

        $this->error('参数错误');
    }
    
    public function update()
	{

        if (!$iId = $this->input->get_post('tea_id', true)) {
            $this->display('error.html');
        }

        $aTeacher = $this->oTeacher->get(array('tea_id'=>intval($iId)));
		
		if ($this->input->get('act') == 'do') {
			$aReceive = $this->input->post(null, true);

			$aResult = $this->oForm->formValidation('teacher_add', $aReceive);
			if ($aResult['code'] != 1) {
				$this->error($aResult['message']);
			}

			if ($this->oTeacher->get(array('code'=>$aReceive['code'], 'where'=>'tea_id != '.$aReceive['tea_id']))) {
				$this->error('编号已存在');
			}
			if ($this->oTeacher->get(array('card_id'=>$aReceive['card_id'], 'where'=>'tea_id != '.$aReceive['tea_id']))) {
				$this->error('身份证号已存在');
			}
			if ($this->oTeacher->get(array('email'=>$aReceive['email'], 'where'=>'tea_id != '.$aReceive['tea_id']))) {
				$this->error('邮箱已被使用');
			}
            
			$aTeacher = $this->oTeacher->update($aReceive);
			if (!$aTeacher) {
				$this->error('修改失败');
			}
			$this->success('修改成功');
		}
		
		$aCollege = $this->oCollege->top();
		$aSpecial = $this->oSpecial->top(array('col_id'=>$aTeacher['col_id']));

		$this->assign('aCollege', $aCollege);
		$this->assign('aSpecial', $aSpecial);
        $this->assign('aTeacher', $aTeacher);

		$this->display('admin/teacher_update.html');
	}

	public function change()
	{
		if ($this->input->get('act') == 'do') {
			$aReceive = $this->input->post(null, true);
			
			$aResult = $this->oForm->formValidation('status_change', $aReceive);
			if ($aResult['code'] != 1) {
				$this->error($aResult['message']);
			}

			$aReceive['tea_id'] = $aReceive['id'];
			unset($aReceive['id']);
			$aTeacher = $this->oTeacher->update($aReceive);
			if (!$aTeacher) {
				$this->error('修改失败');
			}
			$this->success('修改成功');
        }
	}


	public function import()
	{
		if ($this->input->get('act') == 'template') {
			$this->load->library('PHPExcel');
			$oPhpExcel = new PHPExcel();
			$RowNum = array('A', 'B', 'C', 'D', 'E', 'F', 'G');
			foreach ($RowNum as $value) {
				$oPhpExcel->getActiveSheet()->getStyle($value)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
			}
			$oRow = $oPhpExcel->setActiveSheetIndex(0);
			$oRow->setCellValue("A1","编号");
			$oRow->setCellValue("B1","姓名");
			$oRow->setCellValue("C1","性别(男填1女填2)");
			$oRow->setCellValue("D1","年龄");
			$oRow->setCellValue("E1","身份证号");
			$oRow->setCellValue("F1","专业代码");
			$oRow->setCellValue("G1","邮箱");

			$oPhpExcel = PHPExcel_IOFactory::createWriter($oPhpExcel, 'Excel2007');
			$sExcelName  = '教师导入模板.xlsx';
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
			header("Content-Type:application/force-download");
			header("Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");
			header("Content-Disposition:attachment;filename=".$sExcelName);
			header("Content-Transfer-Encoding:binary");
			$oPhpExcel->save('php://output');
			exit;
		}

		if ($this->input->get('act') == 'do') {
			if (empty($_FILES['file'])) {
                $this->smarty->error('请先选择一个文件');
            }

            $ext = explode('.', $_FILES['file']['name']);
            if (!in_array(end($ext), array('xls', 'xlsx'))) {
                $this->smarty->error('请使用xls或xlsx文件');
            }

            $this->load->library('PHPExcel');
            $PHPReader = new PHPExcel_Reader_Excel2007();
            if(!$PHPReader->canRead($_FILES['file']['tmp_name'])){
                $PHPReader = new PHPExcel_Reader_Excel5();
                if(!$PHPReader->canRead($_FILES['file']['tmp_name'])){
                    $this->smarty->error('文件不是真实的EXCEL文件，请另存为xls或xlsx文件');
                }
            }

            $PHPExcel = $PHPReader->load($_FILES['file']['tmp_name']);
            $sheet = $PHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumm = $sheet->getHighestColumn();
            $highestColumm++;

            if ($highestRow == 1) {
                $this->smarty->error('数据表为空');
            }

			$errorinfo = '';
            for ($row = 2; $row <= $highestRow; $row++){
                for ($column = 'A'; $column != $highestColumm; $column++) {
					$columnRowValue = $sheet->getCell($column.$row)->getFormattedValue();
                    if (!$columnRowValue) {
						$errorinfo .= '第'.$row.'行'.$column.'列数据未填写<br/>';
					}
					$aData[($row - 2)][] = $columnRowValue;
                }
			}
			if ($errorinfo) {
				$this->error($errorinfo);   
			}

			$success = 0;
			$error = 0;
			$errorinfo = '';
			$aTeacher = $this->oTeacher->top(array('select'=>'tea_id,code'));
			if ($aTeacher) {
				$aTeacher = array_column($aTeacher, null, 'code');
				$aSpecial = $this->oSpecial->top(array('select'=>'code,spe_id,col_id'));
				if ($aSpecial) {
					$aSpecial = array_column($aSpecial, null, 'code');
				}
			}
			foreach ($aData as $key => $value) {
				if (!isset($aSpecial[$value[5]])) {
					$error ++;
					$errorinfo .= '第'.($key+2).'行专业不存在，请先添加专业<br>';
					continue;
				}
				if (isset($aTeacher[$value[0]])) {
					$result = $this->oTeacher->update(array(
						'tea_id'=>$aTeacher[$value[0]]['tea_id'], 
						'code'=>$value[0], 
						'name'=>$value[1], 
						'sex'=>$value[2],
						'age'=>$value[3],
						'card_id'=>$value[4], 
						'email'=>$value[6],
						'spe_id'=>$aSpecial[$value[5]]['spe_id'],
						'col_id'=>$aSpecial[$value[5]]['col_id']
					));
				}else{
					$password = substr($value[4], -6);
					$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
					$salt = $chars[rand(0,35)].$chars[rand(0,35)].$chars[rand(0,35)].$chars[rand(0,35)];
					$password = md5(md5($password).$salt);
					$result = $this->oTeacher->add(array(
						'code'=>$value[0], 
						'name'=>$value[1], 
						'sex'=>$value[2],
						'age'=>$value[3],
						'card_id'=>$value[4], 
						'email'=>$value[6],
						'spe_id'=>$aSpecial[$value[5]]['spe_id'],
						'col_id'=>$aSpecial[$value[5]]['col_id'],
						'password'=>$password,
						'salt'=>$salt
					));
				}
				if ($result) {
					$success ++;
				}else{
					$error ++;
					$errorinfo .= '第'.($key+2).'行数据操作失败，请检查数据<br>';
				}
			}

			$this->oLog->add(array('content'=>'导入教师：成功'.$success.'条,失败'.$error.'条'));
			if ($errorinfo) {
				$this->error($errorinfo);
			}
            $this->success('', '/admin/teacher/lists');
		}
		
		$this->display('admin/teacher_import.html');
	}
}
