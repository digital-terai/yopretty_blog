<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\maguttiCms\Tools\Stringable;

class Media extends Model
{
	use \Dimsav\Translatable\Translatable;
	use \App\maguttiCms\Translatable\GFTranslatableHelperTrait;

	protected   $table = 'media';
	public      $translatedAttributes = ['title','alt','description'];
	protected   $fillable = ['title','description','sort','media_category_id'];
	protected   $fieldspec = [];


	public function media()
	{
		return $this->morphTo();
	}

	public function media_category()
	{
		return $this->belongsTo('App\Domain','media_category_id','id');
	}


	public function getPreviewAttribute()
	{
		return ma_get_image_from_repository( $this->file_name);
	}

	function getFieldSpec ()
	// set the specifications for this database table
	{

		// build array of field specifications
		$this->fieldspec['id'] = [
			'type'     => 'integer',
			'minvalue' => 0,
			'pkey'     => 'y',
			'required' =>true,
			'label'    => 'id',
			'hidden'   => 1,
			'display'  => 1,
		];
		$this->fieldspec['file_name'] = [
			'type'      => 'readonly',
			'required'  => true,
			'hidden'    => 0,
			'label'     => 'File name',
			'lang'      => 0,
			'display'   => 1,

		];
		$this->fieldspec['media_category_id'] = [
			'type'          => 'relation',
			'model'         => 'Domain',
			'filter'        =>  ['domain' => 'imagetype'],
			'foreign_key'   => 'id',
			'label_key'     => 'title',
			'label'     => 'Media Category',
			'hidden'    => 0,
			'required'  =>  false,
			'display'   => 1,
		];
		$this->fieldspec['title'] = [
			'type'      => 'string',
			'required'  => true,
			'hidden'    => 0,
			'label'     => 'Title',
			'display'   => 1,
		];
		$this->fieldspec['alt'] = [
			'type'      => 'string',
			'required'  => false,
			'hidden'    => 0,
			'label'     => 'Alt',
			'display'   => 1,
		];
		$this->fieldspec['description'] = [
			'type'      => 'text',
			'size'      => 600,
			'h'         => 100,
			'required'  => true,
			'hidden'    => 0,
			'label'     => 'Description',
			'cssClass'  => 'smallArea',
			'display'   => 1,
		];
		$this->fieldspec['sort'] = [
			'type'      => 'integer',
			'required'  => false,
			'label'     => 'Order',
			'hidden'    => 0,
			'display'   => 1,
		];

		$this->fieldspec['pub'] = [
			'type'      => 'boolean',
			'pkey'      => 'n',
			'required'  => false,
			'hidden'    => 0,
			'label'     => trans('admin.label.publish'),
			'display'   => 1
		];

		return $this->fieldspec;
	}

	/**
	* @param $query
	* @param string $media_category_id
	*/

	public function scopeGallery($query,$media_category_id='')    {
		if($media_category_id!='') $query->where('media_category_id',$media_category_id) ;
		$query->orderBy('sort', 'asc');
	}

	public function scopeImages($query)
	{
		return $query->where('collection_name', 'images');
	}
	public function scopeDocuments($query)
	{
		return $query->where('collection_name', 'docs');
	}

	public function url() {
		switch ($this->collection_name) {
			case 'images': return get_image($this->file_name); break;
			case 'docs': return get_doc($this->file_name); break;
		}
	}

	public function path() {
		switch ($this->collection_name) {
			case 'images': return ma_get_image_path_from_repository($this->file_name); break;
			case 'docs': return ma_get_doc_path_from_repository($this->file_name); break;
		}
	}

	public function getFileSize() {
		return Stringable::humanReadableFileSize($this->size);
	}
}
