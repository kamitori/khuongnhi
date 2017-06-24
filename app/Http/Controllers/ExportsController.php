<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\PdfTemplate;
use Session;
use Storage;
use DB;

class ExportsController extends Controller {
	protected $layout = 'export.index';

	public function __construct()
	{
		date_default_timezone_set('Asia/Ho_Chi_Minh');
	}
	
	public function getIndex(Request $request){
		
	}

	public function getTry($id_pdf=0){
		if($id_pdf){
			$pdf = PdfTemplate::find($id_pdf)->toArray();
			$don_gia1 = rand(30,100)*1000;
			$don_gia2 = rand(30,100)*1000;
			$so_luong1 = rand(1,10)*10;
			$so_luong2 = rand(1,10)*10;
			$table_list = '<table class="table_list">
					<thead>
						<tr>
							<th>Mã</th>
							<th>Tên</th>
							<th class="money">Đơn giá</th>
							<th>Số lượng</th>
							<th class="money">Thành tiền</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>A1234</td>
							<td>Quần áo trẻ em</td>
							<td  class="money">'.$don_gia1.'</td>
							<td>'.$so_luong1.'</td>
							<td  class="money">'.($don_gia1*$so_luong1).'</td>
						</tr>
						<tr>
							<td>A6789</td>
							<td>Đồ dùng trẻ em</td>
							<td  class="money">'.$don_gia2.'</td>
							<td>'.$so_luong2.'</td>
							<td  class="money">'.($don_gia2*$so_luong2).'</td>
						</tr>';
			$table_list .=		'<tr class="sum">
							<td colspan="4">Tổng cộng</td>
							<td class="money">'.(($don_gia1*$so_luong1)+($don_gia2*$so_luong2)).'</td>
						</tr>';
			$table_list .=		'</tbody>
				</table>';
			$id = rand(1,500);
			$toa_moi = ($don_gia1*$so_luong1)+($don_gia2*$so_luong2);
			$no_cu = $toa_moi *rand(50,500)/100;
			$tong_cong = $no_cu + $toa_moi;
			$date = date('d-m-Y');
			$month = date('m');
			$year = date('Y');
			$date_print = date('d-m-Y');
			$company_name = 'Cơ sở may Khương Nhi';
			$address = '33/6 Đường số 19, P5, Gò Vấp';
			$phone = '08. 35171589';


			$pdf = str_replace('{{$table_list}}',$table_list,$pdf);
			$pdf = str_replace('{{$date_print}}',$date_print,$pdf);
			$pdf = str_replace('{{$toa_moi}}',number_format($toa_moi),$pdf);
			$pdf = str_replace('{{$no_cu}}',number_format($no_cu),$pdf);
			$pdf = str_replace('{{$tong_cong}}',number_format($tong_cong),$pdf);
			$pdf = str_replace('{{$date}}',$date,$pdf);
			$pdf = str_replace('{{$month}}',$month,$pdf);
			$pdf = str_replace('{{$year}}',$year,$pdf);
			$pdf = str_replace('{{$id}}',$id,$pdf);
			$pdf = str_replace('{{$company_name}}',$company_name,$pdf);
			$pdf = str_replace('{{$address}}',$address,$pdf);
			$pdf = str_replace('{{$phone}}',$phone,$pdf);
			$this->layout->content = $pdf['template'];
			$this->layout->oriental = $pdf['oriental'];
		}else{
			$this->layout->content =  "<h1>Not found template</h1>";
		}
	}

	public function postPrintTest(Request $request){
		$arr_return = array('status'=>'error');
		$id = $request->has('id')?$request->input('id'):0;
		$name = $request->has('name')?$request->input('name'):0;
		$name = Str::slug($name,'_');
		if($id){
			$cmd = public_path().'\\phantomjs\\phantomjs '. public_path().'\\phantomjs\\rasterize.js '.URL.'/exports/try/'.$id.'?phantomjs='.md5('phantomjs').' '.public_path().'\\upload\\'.$name.'.pdf 8.3in*11.7in 0.96';
			if(exec($cmd)){
				$arr_return['status'] = 'success';
				$arr_return['link'] = URL.'/upload/'.$name.'.pdf';
			}else{
				$arr_return['message'] = 'Error print';
			}
		}else{
			$arr_return['message'] = 'Not found';
		}
		return $arr_return;
	}

	public static function getCreatePrintPdf($arr_print,$id_template,$name,$oriental='potrait'){
		$pdf = PdfTemplate::find($id_template)->toArray();
		// pr($pdf);
		$oriental = $pdf['oriental'];
		
		$arr_body = $arr_print['arr_list']['arr_body'];
		$arr_sum = $arr_print['arr_list']['arr_sum'];
		$arr_head = $arr_print['arr_list']['arr_head'];
		$arr_key = $arr_print['arr_list']['arr_key'];
		$arr_data = $arr_print['arr_data'];
		// if(count($arr_body)){
			$table_list = 	'<table class="table_list">
						<thead>
							<tr>';
			foreach ($arr_head as $key => $value) {
				$table_list.='<th class="'.$value['class'].'">'.str_replace(" ", "&nbsp;", $value['text']).'</th>';
			}
			$table_list .='			</tr>
						</thead>
						<tbody>';
			foreach ($arr_body as $key => $value) {
				$table_list.='		<tr>';
				foreach ($arr_key as $key1 => $value1) {
					$table_list.='		<td class="'.$arr_head[$key1]['class'].'">'.$value[$value1].'</td>';
				}
				$table_list.='		</tr>';
			}
			
			foreach ($arr_sum as $key => $sum) {
				$table_list.='			<tr class="sum">';
				foreach ($sum as $key2 => $value){
					// pr($value['colspan']);die;
					$class = isset($value['class'])?$value['class']:'money';
					if($key2==0){
						$table_list.='		<td colspan="'.$value['colspan'].'">'.$value['value'].'</td>';
					}else{
						$table_list.='		<td class="'.$class.'">'.$value['value'].'</td>';
					}
				}
				$table_list.='			</tr>';
			}
			
			$table_list.= '		</tbody>
					</table>';
			$pdf = str_replace('{{$table_list}}',$table_list,$pdf);
			foreach ($arr_data as $key => $value) {
				$pdf = str_replace('{{$'.$key.'}}',$value,$pdf);
			}
			
		// }else{

		// 	$pdf = str_replace('{{$table_list}}',$table_list,$pdf);
		// }
		$content =  view('export.index',[
						'content'=>$pdf['template'],
						'oriental'=>$oriental
					])->render();
		$time = time();
		$file_name = md5($time).'.html';
		file_put_contents(public_path().'\\cache\\'.$file_name, $content);
		if($oriental=='landscape'){
			$cmd = public_path().'\\phantomjs\\phantomjs '. public_path().'\\phantomjs\\rasterize.js '.URL.'/cache/'.$file_name.' '.public_path().'\\upload\\'.$name.'_'.$time.'.pdf 11.7in*8.3in 0.96';
		}
		else{
			$cmd = public_path().'\\phantomjs\\phantomjs '. public_path().'\\phantomjs\\rasterize.js '.URL.'/cache/'.$file_name.' '.public_path().'\\upload\\'.$name.'_'.$time.'.pdf 8.3in*11.7in 0.96';
		}
		// echo $cmd;die;
		if(exec($cmd)){
			return   URL.'/upload/'.$name.'_'.$time.'.pdf';
		}
	}

	public static function getCreatePrintExcel($arr_print,$id_template,$name){
		if(strlen($name)>32){
			$name = substr($name, 0, 31);
		}
		\Excel::create($name, function($excel) use ($arr_print,$id_template,$name){
				$excel->sheet($name, function($sheet) use ($arr_print,$id_template,$name){
					$cache = \Cache::get('list_product'.\Auth::user()->id);
					$so_cot = count($arr_print['arr_list']['arr_head']);
					$so_dong = count($arr_print['arr_list']['arr_body']);
					$arr_header = array();
					$arr_columns = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N");
					$arr_format = array();
					$arr_align = array();
					foreach ($arr_print['arr_list']['arr_head'] as $key => $value) {
						$arr_header[] = $value['text'];
						if($value['class']=='money'){
							$arr_format[$arr_columns[$key]]= '#,##0';
						}
						if($value['class']=='center'){
							$sheet->getStyle($arr_columns[$key].'1:'.$arr_columns[$key].($so_dong+1))->getAlignment()->applyFromArray(
							    	array('horizontal' => 'center')
							);
						}
					}
					
					$sheet->row(1, $arr_header);
					$sheet->setColumnFormat($arr_format);
					$sheet->cell('A1:'.$arr_columns[$so_cot-1].'1', function($cell){
						$cell->setFontWeight('bold');
					});
					$index=0;
					foreach ($arr_print['arr_list']['arr_body'] as $key => $value) {
						$index++;
						$arr_tmp = array();
						$arr_tmp[] = $index;
						foreach ($arr_print['arr_list']['arr_key'] as $key2 => $value2) {
							$arr_tmp[] = $value[$value2];
						}
						$sheet->appendRow($index+1,$arr_tmp);
					}
					$sheet->setStyle(array(
					    'font' => array(
					        'name'      =>  'Arial',
					        'size'      =>  11
					    )
					));
					if(isset($arr_print['arr_list']['arr_sum'])){
						
						foreach ($arr_print['arr_list']['arr_sum'] as $key => $value) {
							$sheet->mergeCells('A'.($so_dong+2).':'.$arr_columns[$value[0]['colspan']].''.($so_dong+2).'');
							$sheet->cell('A'.($so_dong+2),function($cell) use ($value){
									$cell->setValue($value[0]['value']) ;
									$cell->setAlignment('right') ;
									$cell->setFontWeight(true);
									$cell->setFontSize(13);
								});
							$sheet->cell($arr_columns[$value[0]['colspan']+1].($so_dong+2),function($cell) use ($so_dong,$so_cot,$arr_columns){
								$cell->setValue('=sum('.$arr_columns[$so_cot-1].'2:'.$arr_columns[$so_cot-1].($so_dong+1).')');
								$cell->setFontWeight(true);
								$cell->setFontSize(13);
							});							
						}
					}
					$sheet->setBorder('A1:'.$arr_columns[$so_cot-1].($so_dong+2),'thin');
					// $sheet->mergeCells('A'.($index+2).':'.'I'.($index+2));
					// $sheet->setCellValue('A'.($index+2),'Tổng vốn lưu:');
					// $sheet->cell('A'.($index+2), function($cell){
					// 	$cell->setAlignment('right');
					// 	$cell->setFontWeight('bold');
					// });
					// $sheet->setCellValue('J'.($index+2),'=sum(J2:J'.($index+1).')');

					// $sheet->setBorder('A1:J'.($index+2), 'thin');
				});
			})->export('xlsx');
			die;
	}
}