<?php

namespace frontend\models;

use common\models\BaseAccessToken;
use common\models\User;

/**
 * This is the model class for table "accesstoken".
 *
 * @property int $id
 * @property int $userId
 * @property string $accessToken
 *
 * @property User $user
 */
class Accesstoken extends BaseAccessToken
{

}
