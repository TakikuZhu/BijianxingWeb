<?php
namespace app\manageWord\model;
use think\Model;
use think\Db;
use think\Request;

class Word extends Model
{
	//添加字
	public function addWord(Request $request)
	{
		$word_photo = $request->file('wordphoto');
		$word_video = $request->file('wordvideo');
		$word_intr_photo = $request->file('intr_photo');
		$word_name = $request->param('_name');
		$book_type = $request->param('_booktype');
		$word_type = $request->param('_wordtype');
		$word_note = $request->param('_note');
		$word_intr_text = $request->param('intr_text');
		/* $word_version = $request->param('_version');
		$word_grade = $request->param('_grade');
		$word_course = $request->param('_course'); */
		$word = $this->findWord($word_name, $book_type, $word_type);
		//判断该字是否存在
		if(count($word))
		{
			return "Word exists, unable to add";
		}
		else
		{
			//判断输入是否一个汉字
			if($word_name == null)
			{
				return "Word is null";
			}
			else if(!preg_match("/^[\x{4e00}-\x{9fa5}]{1,1}+$/u", $word_name))
			{
				return "One chinese word at a time";
			}
			else
			{
				if(($book_type != 0) && ($word_type != 0))
				{
					//添加字图
					if($word_photo)
					{
						$photoInfo = $word_photo->move(ROOT_PATH. 'public/static/libraryResources/img');
						if ($photoInfo)
						{
							$word_photo_url = str_replace('\\', "/", $photoInfo->getSaveName());
							$wp_img_url = "../../static/libraryResources/img/".$word_photo_url;
							Db::name('word_photo')->insert(['wp_name' => $word_name, 'wp_img_url' => $wp_img_url,
									'wp_bt_id' => $book_type, 'wp_wt_id' => $word_type]);
							$wp_id = Db::name('word_photo')->getLastInsID();
						}
					}
					else
					{
						//当上传文件为空时仅添加一条记录
						Db::name('word_photo')->insert(['wp_name' => $word_name, 'wp_bt_id' => $book_type, 'wp_wt_id' => $word_type]);
						//获取字图id
						$wp_id = Db::name('word_photo')->getLastInsID();
					}
					//添加书写要点
					if($word_note != null)
					{
						Db::name('word_note')->insert(['wn_name' => $word_name, 'wn_dcp' => $word_note]);
						$wn_id = Db::name('word_note')->getLastInsID();
					}
					else
					{
						Db::name('word_note')->insert(['wn_name' => $word_name]);
						$wn_id = Db::name('word_note')->getLastInsID();
					}
					//添加视频
					if($word_video)
					{
						$videoInfo = $word_video->move(ROOT_PATH.'public'.DS.'static'.DS.'libraryResources'.DS.'video');
						if($videoInfo)
						{
							$word_video_url = str_replace('\\', "/", $videoInfo->getSaveName());
							$wv_video_url = "../../static/libraryResources/video/".$word_video_url;
							Db::name('word_video')->insert(['wv_name' => $word_name, 'wv_video_url' => $wv_video_url,
									'wv_bt_id' => $book_type, 'wv_wt_id' => $word_type]);
							$wv_id = Db::name('word_video')->getLastInsID();
						}
					}
					else
					{
						Db::name('word_video')->insert(['wv_name' => $word_name, 'wv_bt_id' => $book_type, 'wv_wt_id' => $word_type]);
						$wv_id = Db::name('word_video')->getLastInsID();
					}
					//添加说文解字
					if(($word_intr_photo) && ($word_intr_text != null))
					{
						$intrPhotoInfo = $word_intr_photo->move(ROOT_PATH.'public'.DS.'static'.DS.'libraryResources'.DS.'img');
						if($intrPhotoInfo)
						{
							$word_intr_photo_url = str_replace('\\', "/", $intrPhotoInfo->getSaveName());
							$intr_photo_url = "../../static/libraryResources/img/".$word_intr_photo_url;
							Db::name('word_intr')->insert(['wi_name' => $word_name, 'wi_dcp' => $word_intr_text, 'wi_img_url' => $intr_photo_url]);
							$wi_id = Db::name('word_intr')->getLastInsID();
						}
					}
					else if(($word_intr_photo) && ($word_intr_text == null))
					{
						$intrPhotoInfo = $word_intr_photo->move(ROOT_PATH.'public'.DS.'static'.DS.'libraryResources'.DS.'img');
						if($intrPhotoInfo)
						{
							$word_intr_photo_url = str_replace('\\', "/", $intrPhotoInfo->getSaveName());
							$intr_photo_url = "../../static/libraryResources/img/".$word_intr_photo_url;
							Db::name('word_intr')->insert(['wi_name' => $word_name, 'wi_dcp' => $word_intr_text, 'wi_img_url' => $intr_photo_url]);
							$wi_id = Db::name('word_intr')->getLastInsID();
						}
					}
					else if(($word_intr_photo == null) && ($word_intr_text != null))
					{
						Db::name('word_intr')->insert(['wi_name' => $word_name, 'wi_dcp' => $word_intr_text, 'wi_img_url' => $word_intr_photo]);
						$wi_id = Db::name('word_intr')->getLastInsID();
					}
					else
					{
						Db::name('word_intr')->insert(['wi_name' => $word_name]);
						$wi_id = Db::name('word_intr')->getLastInsID();
					}
					//添加字信息表记录
					Db::name('word_info')->insert(['wi_name' => $word_name, 'wi_bt_id' => $book_type, 'wi_wt_id' => $word_type,
							'wi_wp_id' => $wp_id, 'wi_wv_id' => $wv_id, 'wi_wi_id' => $wi_id, 'wi_wn_id' => $wn_id]);
					/* //判断是否把该字添加到生字表
					if(($word_version != null) && ($word_grade != null) && ($word_course != null))
					{
						//判断该生字是否在生字表中
						$newWord = $this->findNewWord($word_name, $word_version, $word_grade, $word_course);
						if(count($newWord))
						{
							return "New word exists, unable to add";
						}
						else
						{
							//当该生字不在生字表中
							//判断生字表中有无该一版本、课程或年级的记录
							$wordList = Db::name('new_word')
							->where('nw_material_type', $word_version)
							->where('nw_grade', $word_grade)
							->where('nw_course', $word_course)
							->select();
							if(count($wordList))
							{
								//当生字表中还有该一版本、课程或年级的记录时
								$wordArray = explode('@@', $wordList[0]['nw_text']);
								array_push($wordArray, $word_name);
								$wordString = implode('@@', $wordArray);
								Db::name('new_word')
									->field(['nw_text'])
									->where('nw_material_type', $word_version)
									->where('nw_grade', $word_grade)
									->where('nw_course', $word_course)
									->update(['nw_text' => $wordString]);
							}
							else
							{
								//当生字表中已无该一版本、课程或年级的记录时
								Db::name('new_word')->insert(['nw_material_type' => $word_version, 'nw_grade' => $word_grade,
										'nw_course' => $word_course, 'nw_text' => $word_name]);
							}
						}
					}
					else
					{
						return "Word add successfully, but not in new word table";
					} */
					return "Word add successfully";
				}
				else
				{
					return "Booktype or wordtype incorrect";
				}
			}
		}
	}
	//删除字
	public function deleteWord(Request $request)
	{
		$word_name = $request->param('wordname');
		$book_type = $request->param('booktype');
		$word_type = $request->param('wordtype');
		//查询该字是否存在
		$word = $this->findWord($word_name, $book_type, $word_type);
		if($word == null)
		{
			return "Word doesn't exist, unable to delete";
		}
		else
		{
			
			$wi_id = $word[0]['wi_id'];
			$wi_wp_id = $word[0]['wi_wp_id'];
			$wi_wv_id = $word[0]['wi_wv_id'];
			$wi_wn_id = $word[0]['wi_wn_id'];
			$wi_wi_id = $word[0]['wi_wi_id'];
			$this->delWordPhoto($wi_wp_id);
			$this->delWordVideo($wi_wv_id);
			$this->delWordNote($wi_wn_id);
			$this->delWordIntr($wi_wi_id);
			Db::name('word_info')
			->where('wi_id', $wi_id)
			->delete();
			//应用场景：当字库内不存在该字，但该字存在于生字表new_word中
			$remainWord = Db::name('word_info')->where('wi_name', $word_name)->select();
			if(!count($remainWord))
			{
				//删除字的分数、评论以及相应的回复
				/* $this->delWordScore($wi_wv_id);
				$this->delWordComment($wordName);
				$this->delWordReply($wordName); */
				//遍历生字表每一条记录
				$newWordList = Db::name('new_word')->select();
				if(count($newWordList))
				{
					foreach($newWordList as $newWord)
					{
						$wordList = $newWord['nw_text'];
						$wordListId = $newWord['nw_id'];
						$wordArray = explode("@@", $wordList);
						for($i = 0; $i < count($wordArray); $i++)
						{
							if($word_name == $wordArray[$i])
							{
								array_splice($wordArray, $i, 1);
								//判断删除该字后该生字表的记录的nw_text字段值是否为空
								if(count($wordArray))
								{
									$wordString = implode("@@", $wordArray);
									Db::name('new_word')->field(['nw_text'])->where('nw_id', $wordListId)
									->update(['nw_text' => $wordString]);
								}
								else
								{
									//该生字表的记录的nw_text字段值为空时删除该生字表记录
									Db::name('new_word')->where('nw_id', $wordListId)->delete();
								}
							}
						}
					}
				}
			}			
			return "Word delete successfully";
		}
	}
	//查找字
	public function findWord($wordName, $bookType, $wordType)
	{
		$word = Db::name('word_info')
		->where('wi_name', $wordName)
		->where('wi_bt_id', $bookType)
		->where('wi_wt_id', $wordType)
		->select();
		if(count($word))
		{
			return $word;
		}
		else
		{
			return null;
		}
	}
	//查找字
	public function searchWord(Request $request)
	{
		$word_name = $request->param('wordname');
		$book_type = $request->param('booktype');
		$word_type = $request->param('wordtype');
		$newWordArray = array();
		//查询生字信息
		$newWordList = Db::name('new_word')->select();
		if(count($newWordList))
		{
			foreach($newWordList as $newWord)
			{
				$wordList = $newWord['nw_text'];
				$wordListId = $newWord['nw_id'];
				$wordListVersion = $newWord['nw_material_type'];
				$wordListGrade = $newWord['nw_grade'];
				$wordListCourse = $newWord['nw_course'];
				$wordArray = explode("@@", $wordList);
				for($i = 0; $i < count($wordArray); $i++)
				{
					if($word_name == $wordArray[$i])
					{
						array_push($newWordArray, $newWord['nw_material_type'], $newWord['nw_grade'], $newWord['nw_course']);
						array_push($newWordArray, $wordListVersion, $wordListGrade, $wordListCourse);
					}
				}
			}
		}
		//查询字信息
		$word = Db::name('word_info')
		->where('wi_name', $word_name)
		->where('wi_bt_id', $book_type)
		->where('wi_wt_id', $word_type)
		->select();
		if(count($word))
		{
			$word_photo_url = $this->getWordPhoto($word);
			$word_video_url = $this->getWordVideo($word);
			$word_intr = explode("@@", $this->getWordIntr($word));
			$word_note = explode("@@", $this->getWordNote($word));
			$word_score = $this->getWordScore($word);
			$word_info = array("word_photo" => $word_photo_url,
					"word_video" => $word_video_url, "word_intr" => $word_intr,
					"word_note" => $word_note, "word_score" => $word_score, "word_version" => $newWordArray[0], 
					"word_grade" => $newWordArray[1], "word_course" => $newWordArray[2]);
			return $word_info;
		}
		else
		{
			return "Word doesn't exist";
		}
		
	}
	//查找生字
	public function findNewWord($wordName, $wordVersion, $wordGrade, $wordCourse)
	{
		$wordList = Db::name('new_word')
		->where('nw_material_type', $wordVersion)
		->where('nw_grade', $wordGrade)
		->where('nw_course', $wordCourse)
		->select();
		if(count($wordList))
		{
			$temp = null;
			$word = explode("@@", $wordList[0]['nw_text']);
			foreach($word as $newWord)
			{
				if($newWord == $wordName)
				{
					$temp = $newWord;
				}
			}
			return $temp;
		}
		else
		{
			return null;
		}
	}
	//查找生字
	public function searchNewWord(Request $request)
	{
		$word_name = $request->param('wordname');
		$newWordList = Db::name('new_word')->select();
		$tempArray = array();
		if(count($newWordList))
		{
			foreach($newWordList as $newWord)
			{
				$wordList = $newWord['nw_text'];
				$wordListId = $newWord['nw_id'];
				$wordListVersion = $newWord['nw_material_type'];
				$wordListGrade = $newWord['nw_grade'];
				$wordListCourse = $newWord['nw_course'];
				$wordArray = explode("@@", $wordList);
				
				for($i = 0; $i < count($wordArray); $i++)
				{
					if($word_name == $wordArray[$i])
					{
						$newWordArray = array();
						array_push($newWordArray, $wordListVersion, $wordListGrade, $wordListCourse);
						array_push($tempArray, $newWordArray);
					}
				}
				
			}
			if(count($tempArray))
			{
				return $tempArray;
			}
			else
			{
				return "Such word doesn't exist in table new word";
			}
		}
		else
		{
			return "All new word retrieve fail";
		}
	}
	//删除字图
	public function delWordPhoto($wordPhotoID)
	{
		$word_photo = Db::name('word_photo')
		->where('wp_id', $wordPhotoID)
		->select();
		if(count($word_photo))
		{
			$url = $word_photo[0]["wp_img_url"];
			if($url != null)
			{
				$urlArray = explode("/", $url);
				array_splice($urlArray, 1, 2);
				$urlArray[0] = '../static';
				$urlString = implode("/", $urlArray);
				unlink($urlString);
			}
			Db::name('word_photo')->where('wp_id', $wordPhotoID)->delete();
			
		}
		else
		{
			return "Photo doesn't exist";
		}
	}
	//删除视频
	public function delWordVideo($wordVideoID)
	{
		$word_video = Db::name('word_video')
		->where('wv_id', $wordVideoID)
		->select();
		if(count($word_video))
		{
			$url = $word_video[0]["wv_video_url"];
			if($url != null)
			{
				
				$urlArray = explode("/", $url);
				array_splice($urlArray, 1, 2);
				$urlArray[0] = '.';
				$urlString = implode("/", $urlArray);
				unlink($urlString);
			}
			Db::name('word_video')->where('wv_id', $wordVideoID)->delete();
			
		}
		else
		{
			return "Video doesn't exist";
		}
	}
	//删除书写要点
	public function delWordNote($wordNoteID)
	{
		$word_note = Db::name('word_note')
		->where('wn_id', $wordNoteID)
		->select();
		if(count($word_note))
		{
			Db::name('word_note')->where('wn_id', $wordNoteID)->delete();
		}
		else
		{
			return "Note doesn't exist";
		}
	}
	//删除得分
	public function delWordScore($wordVideoID)
	{
		$word_score = Db::name('score')
		->where('score_wv_id', $wordVideoID)
		->select();
		if(count($word_score))
		{
			Db::name('score')->where('score_wv_id', $wordVideoID)->delete();
		}
		else
		{
			return "Score doesn't exist";
		}
	}
	//删除说文解字
	public function delWordIntr($wordIntrID)
	{
		$word_intr = Db::name('word_intr')
		->where('wi_id', $wordIntrID)
		->select();
		if(count($word_intr))
		{
			$url = $word_intr[0]["wi_img_url"];
			if($url != null)
			{
				$urlArray = explode("/", $url);
				array_splice($urlArray, 1, 2);
				$urlArray[0] = '.';
				$urlString = implode("/", $urlArray);
				unlink($urlString);
			}
			Db::name('word_intr')->where('wi_id', $wordIntrID)->delete();
			
		}
		else
		{
			return "Intr doesn't exist";
		}
	}
	//删除全部评论
	public function delWordComment($wordName)
	{
		$comment = Db::name('comment')
		->where('wc_name', $wordName)
		->select();
		if(count($comment))
		{
			Db::name('comment')->where('wc_name', $wordName)->delete();
		}
		else
		{
			var_dump('该字的评论不存在，无法删除');
		}
	}
	//删除某一评论
	public function delWordCommentByCommentId($commentId)
	{
		$comment = Db::name('comment')
		->where('wc_id', $commentId)
		->select();
		if(count($comment))
		{
			Db::name('comment')->where('wc_id', $commentId)->delete();
		}
		else
		{
			var_dump('该评论不存在，无法删除');
		}
	}
	//删除全部回复
	public function delWordReply($wordName)
	{
		$reply = Db::name('reply')
		->where('wr_name', $wordName)
		->select();
		if(count($reply))
		{
			Db::name('reply')->where('wr_name', $wordName)->delete();
		}
		else
		{
			var_dump('该字的回复不存在，无法删除');
		}
	}
	//删除某一回复
	public function delWordReplyByReplyId($replyId)
	{
		$reply = Db::name('reply')
		->where('wr_id', $replyId)
		->select();
		if(count($reply))
		{
			Db::name('reply')->where('wr_id', $replyId)->delete();
		}
		else
		{
			var_dump('该回复不存在，无法删除');
		}
	}
	//更新评论点赞数
	public function updateThumbUp($comment_id, $thumb_up)
	{
		$comment = Db::name('comment')
		->where('wc_id', $comment_id)
		->select();
		if(count($comment))
		{
			Db::name('comment')
			->where('wc_id', $comment_id)
			->update(['wc_thumbup' => ($comment[0]['wc_thumbup'] + $thumb_up)]);
			return "评论点赞数更新成功";
		}
		else
		{
			var_dump("没有评论");
		}
	}
	//获取字图url
	public function getWordPhoto($word)
	{
		if(count($word))
		{
			$wp_id = $word[0]["wi_wp_id"];
			$word_photo = Db::name('word_photo')
			->where('wp_id', $wp_id)
			->select();
			if(count($word_photo))
			{
				$wp_url = $word_photo[0]["wp_img_url"];
				return $wp_url;
			}
			else
			{
				return "No photo for such word";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//获取视频url
	public function getWordVideo($word)
	{
		if(count($word))
		{
			$wv_id = $word[0]['wi_wv_id'];
			$word_video = Db::name('word_video')
			->where('wv_id', $wv_id)
			->select();
			if(count($word_video))
			{
				$wv_url = $word_video[0]['wv_video_url'];
				return $wv_url;
			}
			else
			{
				return "No video for such word";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//获取说文解字内容
	public function getWordIntr($word)
	{
		if(count($word))
		{
			$wi_id = $word[0]['wi_wi_id'];
			$word_intr = Db::name('word_intr')
			->where('wi_id', $wi_id)
			->select();
			if(count($word_intr))
			{
				$wi_dcp = $word_intr[0]['wi_dcp'];
				$wi_img_url = $word_intr[0]['wi_img_url'];
				return $wi_dcp. '@@'. $wi_img_url;
			}
			else
			{
				return "No intr for such word";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//获取书写要点
	public function getWordNote($word)
	{
		if(count($word))
		{
			$wn_id = $word[0]['wi_wn_id'];
			$word_note = Db::name('word_note')
			->where('wn_id', $wn_id)
			->select();
			if(count($word_note))
			{
				$wn_dcp = $word_note[0]['wn_dcp'];
				return $wn_dcp;
			}
			else
			{
				return "No dcp for such word";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
		return $word_note;
	}
	//获取字的得分
	public function getWordScore($word)
	{
		if(count($word))
		{
			$ws_id = $word[0]['wi_wv_id'];
			$word_score_list = Db::name('score')
			->where('score_wv_id', $ws_id)
			->column('score_num');
			if(count($word_score_list))
			{
				$word_score = round(array_sum($word_score_list) / count($word_score_list));
				return $word_score;
			}
			else
			{
				return "No score for such word";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//更新书写要点
	public function updateWordNote($data)
	{
		$word_name = $data['wordname'];
		$book_type = $data['booktype'];
		$word_type = $data['wordtype'];
		$word_note = $data['wordnote'];
		$word = $this->findWord($word_name, $book_type, $word_type);
		if(count($word))
		{
			if($word_note != null)
			{
				Db::name('word_note')->field(['wn_dcp'])->where('wn_name', $word_name)->update(['wn_dcp' => $word_note]);
				return "Note update succeed";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//更新字图
	public function updateWordPhoto($data)
	{
		$word_name = $data['wordname'];
		$book_type = $data['booktype'];
		$word_type = $data['wordtype'];
		$word_photo_url = $data['wordphotourl'];
		$word = $this->findWord($word_name, $book_type, $word_type);
		if(count($word))
		{
			if($word_photo_url != null)
			{
				$wordPhotoId = $word[0]['wi_wp_id'];
				$wordPhoto = Db::name('word_photo')->where('wp_id', $wordPhotoId)->select();
				if(count($wordPhoto))
				{
					$url = $wordPhoto[0]['wp_img_url'];
					if($url != null)
					{
						$urlArray = explode("/", $url);
						array_splice($urlArray, 1, 2);
						$urlArray[0] = '.';
						$urlString = implode("/", $urlArray);
						unlink($urlString);
					}
				}
				Db::name('word_photo')->field(['wp_img_url'])->where('wp_id', $wordPhotoId)->update(['wp_img_url' => $word_photo_url]);
				return "Photo update succeed";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//图片上传
	public function uploadWordPhoto(Request $request)
	{
		$word_photo = $request->file('wordphoto');
		$word_name = $request->param('_name');
		$book_type = $request->param('_booktype');
		$word_type = $request->param('_wordtype');
		$word_note = $request->param('_note');
		if($word_photo)
		{
			$photoInfo = $word_photo->move(ROOT_PATH.'public'.DS.'static'.DS.'libraryResources'.DS.'img');
			if ($photoInfo) 
			{
				$word_photo_url = str_replace('\\', "/", $photoInfo->getSaveName());
				$url = "/bijianxing/public/static/libraryResources/img/".$word_photo_url;
				$photo = ['wordname' => $word_name, 'booktype' => $book_type, 'wordtype' => $word_type, 'wordphotourl' => $url];
				$photoStatus = $this->updateWordPhoto($photo);
				if($photoStatus == "Word doesn't exist")
				{
					return "Word doesn't exist";
				}
				else
				{
					return "Photo upload succeed";
				}
			}
		}
		if($word_note != null)
		{
			$note = ['wordname' => $word_name, 'booktype' => $book_type, 'wordtype' => $word_type, 'wordnote' => $word_note];
			$noteStatus = $this->updateWordNote($note);
			if($noteStatus == "Word doesn't exist")
			{
				return "Word doesn't exist";
			}
			else
			{
				return "Photo upload succeed";
			}
		}
		if(($word_photo == null) && ($word_note == null))
		{
			// 上传失败获取错误信息
			return "Photo upload fail";
		}
	}
	
	//更新视频
	public function updateWordVideo($data)
	{
		$word_name = $data['wordname'];
		$book_type = $data['booktype'];
		$word_type = $data['wordtype'];
		$word_video_url = $data['wordvideourl'];
		$word = $this->findWord($word_name, $book_type, $word_type);
		if(count($word))
		{
			if($word_video_url != null)
			{
				$wordVideoId = $word[0]['wi_wv_id'];
				$wordVideo = Db::name('word_video')->where('wi_id', $wordVideoId)->select();
				if(count($wordVideo))
				{
					$url = $wordVideo[0]['wv_video_url'];
					if($url != null)
					{
						$urlArray = explode("/", $url);
						array_splice($urlArray, 1, 2);
						$urlArray[0] = '.';
						$urlString = implode("/", $urlArray);
						unlink($urlString);
					}
				}
				Db::name('word_video')->field(['wv_video_url'])->where('wv_id', $wordVideoId)->update(['wv_video_url' => $word_video_url]);
				return "Video update succeed";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	
	//上传视频
	public function uploadVideo(Request $request)
	{
		// 获取表单上传视频
		$word_video = $request->file('wordvideo');
		$word_name = $request->param('_name');
		$book_type = $request->param('_booktype');
		$word_type = $request->param('_wordtype');
		if($word_video)
		{
			$videoInfo = $word_video->move(ROOT_PATH.'public'.DS.'static'.DS.'libraryResources'.DS.'video');
			if($videoInfo)
			{
				$word_video_url = str_replace('\\', "/", $videoInfo->getSaveName());
				$url = "/bijianxing/public/static/libraryResources/video/".$word_video_url;
				$data = ['wordname' => $word_name, 'booktype' => $book_type, 'wordtype' => $word_type, 'wordvideourl' => $url];
				$status = $this->updateWordVideo($data);
				if($status == "Word doesn't exist")
				{
					return "Word doesn't exist";
				}
				else
				{
					return "Video upload succeed";
				}
			}
		}
		else
		{
			return "Video upload fail";
		}
	}
	//上传说文解字
	public function uploadIntr(Request $request)
	{
		// 获取表单上传
		$word_name = $request->param('_name');
		$book_type = $request->param('_booktype');
		$word_type = $request->param('_wordtype');
		$word_intr_text = $request->param('intr_text');
		$word_intr_photo = $request->file('intr_photo');
		if($word_intr_photo)
		{
			$intrPhotoInfo = $word_intr_photo->move(ROOT_PATH.'public'.DS.'static'.DS.'libraryResources'.DS.'img');
			if($intrPhotoInfo)
			{
				$word_intr_photo_url = str_replace('\\', "/", $intrPhotoInfo->getSaveName());
				$intr_photo_url = "/bijianxing/public/static/libraryResources/img/".$word_intr_photo_url;
				$intrPhoto = ['wordname' => $word_name, 'booktype' => $book_type, 'wordtype' => $word_type, 'wordintrphotourl' => $intr_photo_url];
				$photoStatus = $this->updateIntrPhoto($intrPhoto);
				if($photoStatus == "Word doesn't exist")
				{
					return "Word doesn't exist";
				}
				else
				{
					return "Intr upload succeed";
				}
			}
		}
		if($word_intr_text != null)
		{
			$intrText = ['wordname' => $word_name, 'booktype' => $book_type, 'wordtype' => $word_type, 'wordintrtext' => $word_intr_text];
			$textStatus = $this->updateIntrText($intrText);
			if($textStatus == "Word doesn't exist")
			{
				return "Word doesn't exist";
			}
			else
			{
				return "Intr upload succeed";
			}
		}
		if(($word_intr_photo == null) || ($word_intr_text == null))
		{
			return "Intr upload fail";
		}
	}
	//更新说文解字图片
	public function updateIntrPhoto($data)
	{
		$word_name = $data['wordname'];
		$book_type = $data['booktype'];
		$word_type = $data['wordtype'];
		$intr_photo = $data['wordintrphotourl'];
		$word = $this->findWord($word_name, $book_type, $word_type);
		if(count($word))
		{
			if($intr_photo != null)
			{
				$intrId = $word[0]['wi_wi_id'];
				$wordIntr = Db::name('word_intr')->where('wi_id', $intrId)->select();
				if(count($wordIntr))
				{
					$url = $wordIntr[0]['wi_img_url'];
					//修改图片url，unlink操作不识别绝对路径，必须./static...开头
					if($url != null)
					{
						$urlArray = explode("/", $url);
						array_splice($urlArray, 1, 2);
						$urlArray[0] = '.';
						$urlString = implode("/", $urlArray);
						unlink($urlString);
					}
				}
				Db::name('word_intr')->field(['wi_img_url'])->where('wi_wi_id', $intrId)->update(['wi_img_url' => $intr_photo]);
				return "Word Intr update successfully";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//更新说文解字文字内容
	public function updateIntrText($data)
	{
		$word_name = $data['wordname'];
		$book_type = $data['booktype'];
		$word_type = $data['wordtype'];
		$intr_text = $data['wordintrtext'];
		$word = $this->findWord($word_name, $book_type, $word_type);
		if(count($word))
		{
			if($intr_text != null)
			{
				Db::name('word_intr')->field(['wi_dcp'])->where('wi_name', $word_name)->update(['wi_dcp' => $intr_text]);
				return "Word Intr update successfully";
			}
		}
		else
		{
			return "Word doesn't exist";
		}
	}
	//更新生字版本、年级和课程
	public function updateNewWord(Request $request)
	{
		$word_name = $request->param('_name');
		//该生字原来的版本、年级和课程
		$old_version = $request->param('oldversion');
		$old_grade = $request->param('oldgrade');
		$old_course = $request->param('oldcourse');
		//该生字新的版本、年级和课程
		$word_version = $request->param('_version');
		$word_grade = $request->param('_grade');
		$word_course = $request->param('_course');
		//查询该生字原来是否存在于生字表中
 		$oldNewWord = $this->findNewWord($word_name, $old_version, $old_grade, $old_course);
		
		if($oldNewWord != null)
		 {
		 	//该生字原来存在于生字表中
			//查询符合修改参数的生字是否存在于生字表中
			$newWord = $this->findNewWord($word_name, $word_version, $word_grade, $word_course);
			if($newWord != null)
			{
				return "New word with new parameters exists";
			}
			else
			{
				//删除原先的生字记录
				$oldNewWordList = Db::name('new_word')
				->where('nw_material_type', $old_version)
				->where('nw_grade', $old_grade)
				->where('nw_course', $old_course)
				->select();
				if(count($oldNewWordList))
				{
					$oldWordList = $oldNewWordList[0]['nw_text'];
					$wordListId = $oldNewWordList[0]['nw_id'];
					$wordArray = explode("@@", $oldWordList);
					for($i = 0; $i < count($wordArray); $i++)
					{
						if($word_name == $wordArray[$i])
						{
							array_splice($wordArray, $i, 1);
							$wordString = implode("@@", $wordArray);
							Db::name('new_word')->field(['nw_text'])->where('nw_id', $wordListId)->update(['nw_text' => $wordString]);
						}
					}
				}
				else
				{
					return "Old record of new word fail to fetch";
				}
				//把生字添加到新版本、年级和课程参数的记录的nw_text字段中
				//判断是否把该字添加到生字表
				if(($word_version != null) && ($word_grade != null) && ($word_course != null))
				{
					//把该字添加到生字表
					//判断生字表中有无新版本、课程或年级的记录
					$wordList = Db::name('new_word')
					->where('nw_material_type', $word_version)
					->where('nw_grade', $word_grade)
					->where('nw_course', $word_course)
					->select();
					if(count($wordList))
					{
						//当生字表中有新版本、课程或年级的记录时
						$wordArray = explode('@@', $wordList[0]['nw_text']);
						array_push($wordArray, $word_name);
						$wordString = implode('@@', $wordArray);
						Db::name('new_word')
						->field(['nw_text'])
						->where('nw_material_type', $word_version)
						->where('nw_grade', $word_grade)
						->where('nw_course', $word_course)
						->update(['nw_text' => $wordString]);
						return "Update successfully";
					}
					else
					{
						//当生字表中无该一版本、课程或年级的记录时
						Db::name('new_word')->insert(['nw_material_type' => $word_version, 'nw_grade' => $word_grade,
								'nw_course' => $word_course, 'nw_text' => $word_name]);
						return "Update successfully";
					}
				}
				else
				{
					return "some parameters missed";
				}
			}
 		}
		else
		{
			//该生字原来不存在于生字表中
			//查询符合修改参数的生字是否存在于生字表中
			$newWord = $this->findNewWord($word_name, $word_version, $word_grade, $word_course);
			if($newWord != null)
			{
				return "New word with new parameters exists";
			}
			else
			{
				//把生字添加到新版本、年级和课程参数的记录的nw_text字段中
				//判断是否把该字添加到生字表
				if(($word_version != null) && ($word_grade != null) && ($word_course != null))
				{
					//把该字添加到生字表
					//判断生字表中有无新版本、课程或年级的记录
					$wordList = Db::name('new_word')
					->where('nw_material_type', $word_version)
					->where('nw_grade', $word_grade)
					->where('nw_course', $word_course)
					->select();
					if(count($wordList))
					{
						//当生字表中有新版本、课程或年级的记录时
						$wordArray = explode('@@', $wordList[0]['nw_text']);
						array_push($wordArray, $word_name);
						$wordString = implode('@@', $wordArray);
						Db::name('new_word')
						->field(['nw_text'])
						->where('nw_material_type', $word_version)
						->where('nw_grade', $word_grade)
						->where('nw_course', $word_course)
						->update(['nw_text' => $wordString]);
						return "Update successfully";
					}
					else
					{
						//当生字表中无该一版本、课程或年级的记录时
						Db::name('new_word')->insert(['nw_material_type' => $word_version, 'nw_grade' => $word_grade,
								'nw_course' => $word_course, 'nw_text' => $word_name]);
						return "Update successfully";
					}
				}
				else
				{
					return "some parameters missed";
				}
			}
		}
	}
	//批量添加生字
	public function multiAddNewWord(Request $request)
	{
		$word_name = $request->param('_name');
		$word_version = $request->param('_version');
		$word_grade = $request->param('_grade');
		$word_course = $request->param('_course');
		$word_name_array = explode('/', $word_name);
		if(($word_name == null) || $word_name == "")
		{
			return "Words are null";
		}
		//判断是否把该字添加到生字表
		if(($word_version != null) && ($word_grade != null) && ($word_course != null))
		{
			//判断该生字是否在生字表中
			$wordExist = array();
			for($i = 0; $i < count($word_name_array); $i++)
			{
				$word = $this->findNewWord($word_name_array[$i], $word_version, $word_grade, $word_course);
				if(count($word))
				{
					array_push($wordExist, $word);
					array_splice($word_name_array, $i, 1);
				}
			}
			//判断生字表中有无该一版本、课程或年级的记录
			$wordList = Db::name('new_word')
			->where('nw_material_type', $word_version)
			->where('nw_grade', $word_grade)
			->where('nw_course', $word_course)
			->select();
			if(count($wordList))
			{
				//当生字表中还有该一版本、课程或年级的记录时
				$wordArray = explode('@@', $wordList[0]['nw_text']);
				foreach($word_name_array as $newWord)
				{
					array_push($wordArray, $newWord);
				}
				$wordString = implode('@@', $wordArray);
				Db::name('new_word')
				->field(['nw_text'])
				->where('nw_material_type', $word_version)
				->where('nw_grade', $word_grade)
				->where('nw_course', $word_course)
				->update(['nw_text' => $wordString]);
				if(count($wordExist))
				{
					$temp = implode('、', $wordExist);
					return $temp;
				}
				else
				{
					return "Multiple new words add successfully";
				}
			}
			else
			{
				//当生字表中已无该一版本、课程或年级的记录时
				Db::name('new_word')->insert(['nw_material_type' => $word_version, 'nw_grade' => $word_grade,
						'nw_course' => $word_course, 'nw_text' => $word_name]);
				return "Multiple new words add successfully";
			}
		}
		else
		{
			return "Booktype or wordtype is incorrect";
		}
	}
	//删除生字
	public function deleteNewWord(Request $request)
	{
		$word_name = $request->param('_name');
		$word_version = $request->param('_version');
		$word_grade = $request->param('_grade');
		$word_course = $request->param('_course');
		$word_name_array = explode('/', $word_name);
		//判断输入生字是否为空
		if(($word_name == null) || $word_name == "")
		{
			/* //判断输入为空时，版本、年级和课程是否为空
			if(($word_version != null) && ($word_grade != null) && ($word_course != null))
			{
				//输入为空但版本、年级和课程不为空时删除该条件下的记录
				//判断当前生字表是否有符合版本、年级和课程条件的记录
				$wordList = Db::name('new_word')
				->where('nw_material_type', $word_version)
				->where('nw_grade', $word_grade)
				->where('nw_course', $word_course)
				->select();
				if(count($wordList))
				{
					Db::name('new_word')
					->where('nw_material_type', $word_version)
					->where('nw_grade', $word_grade)
					->where('nw_course', $word_course)
					->delete();
					return "all words with condition has been deleted";
				}
				else
				{
					return "Record with such condition no longer exist";
				}
			}
			else
			{
				return "All condition null";
			} */
			return "Word is null";
		}
		else
		{
			//判断是否把该字从生字表中删除
			if(($word_version != null) && ($word_grade != null) && ($word_course != null))
			{
				//判断生字表中有无该一版本、课程或年级的记录
				$wordList = Db::name('new_word')
				->where('nw_material_type', $word_version)
				->where('nw_grade', $word_grade)
				->where('nw_course', $word_course)
				->select();
				if(count($wordList))
				{
					//标识当前生字是否存在于当前所查询的数据库记录中
					$status = null;
					$wordListId = $wordList[0]['nw_id'];
					//当生字表中还有该一版本、课程或年级的记录时
					$wordArray = explode('@@', $wordList[0]['nw_text']);
					//判断输入的字是否存在此纪录中
					foreach($word_name_array as $word)
					{
						$status = $this->findNewWord($word, $word_version, $word_grade, $word_course);
					}
					if($status == null)
					{
						return "Some words no longer exist";
					}
					else
					{
						//只有输入的字都存在于此纪录时才能删除生字
						for($i = 0; $i < count($wordArray); $i++)
						{
							foreach($word_name_array as $word)
							{
								if($wordArray[$i] == $word)
								{
									array_splice($wordArray, $i, 1);
								}
							}
						}
						//判断删除完当前所输入的生字后该记录的nw_text是否为空，不为空update，为空delete
						if(count($wordArray))
						{
							$wordString = implode('@@', $wordArray);
							Db::name('new_word')
							->field(['nw_text'])
							->where('nw_material_type', $word_version)
							->where('nw_grade', $word_grade)
							->where('nw_course', $word_course)
							->update(['nw_text' => $wordString]);
							return "New word delete successfully";
						}
						else
						{
							Db::name('new_word')->where('nw_id', $wordListId)->delete();
							return "New word delete successfully";
						}
					}
				}
				else
				{
					return "Record with such condition no longer exist";
				}
			}
			else
			{
				return "Version or grade or course is incorrect";
				/* //当版本、年级或课程为空时
				//遍历生字表每一条记录
				$newWordList = Db::name('new_word')->select();
				if(count($newWordList))
				{
					foreach($word_name_array as $word)
					{
						foreach($newWordList as $newWord)
						{
							$wordList = $newWord['nw_text'];
							$wordListId = $newWord['nw_id'];
							$wordArray = explode("@@", $wordList);
							for($i = 0; $i < count($wordArray); $i++)
							{
								if($word == $wordArray[$i])
								{
									array_splice($wordArray, $i, 1);
									//判断删除该字后该生字表的记录的nw_text字段值是否为空
									if(count($wordArray))
									{
										$wordString = implode("@@", $wordArray);
										Db::name('new_word')->field(['nw_text'])->where('nw_id', $wordListId)
										->update(['nw_text' => $wordString]);
									}
									else
									{
										//该生字表的记录的nw_text字段值为空时删除该生字表记录
										Db::name('new_word')->where('nw_id', $wordListId)->delete();
									}
								}
							}
						}
					}
				} */
			}
		}
	}
}
?>