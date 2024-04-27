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
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue query()
 */
	class AdFilterValue extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Street|null $street
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
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
 * @property-read Advertisement|null $advertisement
 * @property-read \App\Models\AdvertisementType|null $advertisement_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Photo> $photos
 * @property-read int|null $photos_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement query()
 */
	class Advertisement extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType query()
 */
	class AdvertisementType extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\AdvertisementType|null $advertisement_type
 * @property-read \App\Models\Filter|null $filter
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter query()
 */
	class AdvertisementTypeFilter extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property mixed $password
 * @property-read \App\Models\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FilterValue> $filter_values
 * @property-read int|null $filter_values_count
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter query()
 */
	class Filter extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\Filter|null $filter
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue query()
 */
	class FilterValue extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
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
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms query()
 */
	class Sms extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \App\Models\City|null $city
 * @method static \Illuminate\Database\Eloquent\Builder|Street newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Street newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Street query()
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
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

