<?php
namespace app\models;

use Yii;
use yii\base\Model;

class ProfileForm extends Model
{
 
public function rules() {
 return [
	[['new_referral_link'], 'free'],
 ];
 }
 
 public function attributeLabels() {
 return ['new_referral_link' => '',];
 }
 
}