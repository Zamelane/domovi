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


namespace App\Models\Addresses{
/**
 * 
 *
 * @property int $id
 * @property int $house
 * @property int|null $structure
 * @property int|null $building
 * @property int|null $apartament
 * @property int $street_id
 * @property-read \App\Models\Addresses\Street $street
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereApartament($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereHouse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStructure($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models\Addresses{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models\Addresses{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property-read \App\Models\Addresses\City $city
 * @method static \Illuminate\Database\Eloquent\Builder|Street newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Street newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Street query()
 * @method static \Illuminate\Database\Eloquent\Builder|Street whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Street whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Street whereName($value)
 */
	class Street extends \Eloquent {}
}

namespace App\Models\Advertisement{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $advertisement_id
 * @property int $address_id
 * @property int $advertisement_type_id
 * @property string $transaction_type
 * @property int $area
 * @property string $measurement_type
 * @property int $is_active
 * @property int|null $is_moderated
 * @property int $is_deleted
 * @property int $is_archive
 * @property string $cost
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Filters\AdFilterValue> $ad_filter_values
 * @property-read int|null $ad_filter_values_count
 * @property-read \App\Models\Addresses\Address $address
 * @property-read Advertisement|null $advertisement
 * @property-read \App\Models\Advertisement\AdvertisementType $advertisement_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Advertisement\Photo> $photos
 * @property-read int|null $photos_count
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereAdvertisementTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereIsArchive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereIsModerated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereMeasurementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertisement whereUserId($value)
 */
	class Advertisement extends \Eloquent {}
}

namespace App\Models\Advertisement{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $is_commercial
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType whereIsCommercial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementType whereName($value)
 */
	class AdvertisementType extends \Eloquent {}
}

namespace App\Models\Advertisement{
/**
 * 
 *
 * @property int $filter_id
 * @property int $advertisement_type_id
 * @property-read \App\Models\Advertisement\AdvertisementType|null $advertisement_type
 * @property-read \App\Models\Filters\Filter|null $filter
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter whereAdvertisementTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertisementTypeFilter whereFilterId($value)
 */
	class AdvertisementTypeFilter extends \Eloquent {}
}

namespace App\Models\Advertisement{
/**
 * 
 *
 * @property int $user_id
 * @property int $advertisement_id
 * @property-read \App\Models\Advertisement\Advertisement $advertisement
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favourite whereUserId($value)
 */
	class Favourite extends \Eloquent {}
}

namespace App\Models\Advertisement{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $advertisement_id
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photo whereName($value)
 */
	class Photo extends \Eloquent {}
}

namespace App\Models\Complaint{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $advertisement_id
 * @property string $description
 * @property int $is_review
 * @property-read \App\Models\Advertisement\Advertisement $advertisement
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint query()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereIsReview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereUserId($value)
 */
	class Complaint extends \Eloquent {}
}

namespace App\Models\Deals{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $employee_id
 * @property int $deal_status_id
 * @property int $advertisement_id
 * @property int $percent
 * @property string $create_date
 * @property string|null $start_date
 * @property string|null $valid_until_date
 * @property int $address_id
 * @property-read \App\Models\Addresses\Address $address
 * @property-read \App\Models\Advertisement\Advertisement $advertisement
 * @property-read \App\Models\Deals\DealStatus $deal_status
 * @property-read \App\Models\User\User|null $employee
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Deal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal query()
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereDealStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Deal whereValidUntilDate($value)
 */
	class Deal extends \Eloquent {}
}

namespace App\Models\Deals{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|DealStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DealStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DealStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|DealStatus whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DealStatus whereId($value)
 */
	class DealStatus extends \Eloquent {}
}

namespace App\Models\Document{
/**
 * 
 *
 * @property int $id
 * @property int $deal_id
 * @property string $path
 * @property-read \App\Models\Deals\Deal $deal
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDealId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePath($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models\Filters{
/**
 * 
 *
 * @property int $filter_id
 * @property int $advertisement_id
 * @property string $value
 * @property-read \App\Models\Advertisement\Advertisement $advertisement
 * @property-read \App\Models\Filters\Filter $filter
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue whereFilterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdFilterValue whereValue($value)
 */
	class AdFilterValue extends \Eloquent {}
}

namespace App\Models\Filters{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Filters\FilterValue> $filter_values
 * @property-read int|null $filter_values_count
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Filter whereType($value)
 */
	class Filter extends \Eloquent {}
}

namespace App\Models\Filters{
/**
 * 
 *
 * @property int $filter_id
 * @property string $value
 * @property-read \App\Models\Filters\Filter|null $filter
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue whereFilterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FilterValue whereValue($value)
 */
	class FilterValue extends \Eloquent {}
}

namespace App\Models\Office{
/**
 * 
 *
 * @property string $code
 * @property int $office_id
 * @property string $open_time
 * @property string $close_time
 * @property-read \App\Models\Office\Office $office
 * @method static \Illuminate\Database\Eloquent\Builder|Day newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Day newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Day query()
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereCloseTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereOfficeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Day whereOpenTime($value)
 */
	class Day extends \Eloquent {}
}

namespace App\Models\Office{
/**
 * 
 *
 * @property int $id
 * @property string|null $name
 * @property int $is_active
 * @property int $address_id
 * @property-read \App\Models\Addresses\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Office\Day> $days
 * @property-read int|null $days_count
 * @method static \Illuminate\Database\Eloquent\Builder|Office newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Office query()
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Office whereName($value)
 */
	class Office extends \Eloquent {}
}

namespace App\Models\Review{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $advertisement_id
 * @property string $description
 * @property int $stars
 * @property string $create_datetime
 * @property string|null $update_datetime
 * @property int|null $is_moderation
 * @property int $is_services
 * @property-read \App\Models\Advertisement\Advertisement $advertisement
 * @property-read \App\Models\User\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereAdvertisementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereCreateDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsModeration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereIsServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereStars($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUpdateDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Review whereUserId($value)
 */
	class Review extends \Eloquent {}
}

namespace App\Models\User{
/**
 * 
 *
 * @property mixed $password
 * @property-read \App\Models\User\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 */
	class Employee extends \Eloquent {}
}

namespace App\Models\User{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models\User{
/**
 * 
 *
 * @property string $token
 * @property string|null $code
 * @property string $ip
 * @property int $phone
 * @property int $attempts
 * @property string $datetime_sending
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereAttempts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereDatetimeSending($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sms whereToken($value)
 */
	class Sms extends \Eloquent {}
}

namespace App\Models\User{
/**
 * 
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property string|null $login
 * @property mixed|null $password
 * @property int $phone
 * @property int|null $is_passed_moderation
 * @property int $is_banned
 * @property int $role_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\User\Role $role
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsPassedModeration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePatronymic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleId($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

