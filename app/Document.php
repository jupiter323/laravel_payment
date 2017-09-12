<?php
namespace App;
use Eloquent;

class Document extends Eloquent {

	protected $fillable = [
							'name',
							'doc_code',
							'dirrection',
							'doc_version'
						];
	protected $primaryKey = 'id';
	protected $table = 'document';


   
}
