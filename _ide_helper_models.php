<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 *
 *
 * @property-read \App\Models\Advertisement|null $advertisement
 * @property-read \App\Models\Filter|null $filter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFilterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFilterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdFilterValue query()
 */
	class AdFilterValue extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \App\Models\Street|null $street
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Address query()
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdFilterValue> $ad_filter_values
 * @property-read int|null $ad_filter_values_count
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Advertisement|null $advertisement
 * @property-read \App\Models\AdvertisementType|null $advertisement_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Photo> $photos
 * @property-read int|null $photos_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement query()
 */
	class Advertisement extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvertisementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvertisementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvertisementType query()
 */
	class AdvertisementType extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \App\Models\AdvertisementType|null $advertisement_type
 * @property-read \App\Models\Filter|null $filter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvertisementTypeFilter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvertisementTypeFilter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AdvertisementTypeFilter query()
 */
	class AdvertisementTypeFilter extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City query()
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property mixed $password
 * @property-read \App\Models\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Employee query()
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FilterValue> $filter_values
 * @property-read int|null $filter_values_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Filter query()
 */
	class Filter extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \App\Models\Filter|null $filter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FilterValue query()
 */
	class FilterValue extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Photo query()
 */
	class Photo extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Sms query()
 */
	class Sms extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property-read \App\Models\City|null $city
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Street newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Street newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Street query()
 */
	class Street extends \Eloquent {}
}

namespace App\Models{
/**
 *
 *
 * @property mixed $password
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role|null $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

