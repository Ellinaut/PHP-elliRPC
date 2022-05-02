<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface PropertyTypeDefinitionInterface extends DefinitionInterface
{
    /**
     * Property value is expected to be used id of type integer.
     */
    public const TYPE_ID = 'id';

    /**
     * Property value is expected to be used as id of type string.
     */
    public const TYPE_ID_STRING = 'idString';

    /**
     * Property value is expected to be used as id and contains an uuid as defined in RFC 4122.
     */
    public const TYPE_UUID = 'uuid';

    /**
     * Property value is expected to be a string.
     */
    public const TYPE_STRING = 'string';

    /**
     * Property value is expected to be an integer.
     */
    public const TYPE_INTEGER = 'integer';

    /**
     * Property value is expected to be a decimal number.
     */
    public const TYPE_DECIMAL = 'decimal';

    /**
     * Property value is expected to be a boolean.
     */
    public const TYPE_BOOLEAN = 'boolean';

    /**
     * Property value is expected to be a string formatted as valid email address as defined by RFC 5322 and RFC 6530.
     */
    public const TYPE_EMAIL = 'email';

    /**
     * Property value is expected to be a date string formatted as ISO 8601 date (YYYY-MM-DD).
     */
    public const TYPE_date = 'date';

    /**
     * Property value is expected to be a time string formatted as ISO 8601 time with timezone (hh:mm:ss±hh:mm).
     */
    public const TYPE_TIME = 'time';

    /**
     * Property value is expected to be a datetime string formatted as ISO 8601 combined date and time with timezone (YYYY-MM-DD\Thh:mm:ss±hh:mm).
     */
    public const TYPE_DATETIME = 'datetime';

    /**
     * Property value is expected to be a duration string formatted as ISO 8601 duration (PT).
     */
    public const TYPE_DURATION = 'duration';

    /**
     * Property value is expected to be a json object formatted and to be interpreted as GeoJson, defined in RFC 7946.
     */
    public const TYPE_GEO_JSON = 'geoJson';

    /**
     * Property value is expected to be a placeholder used in wrapper schemas where the wrapped content later should go. The schema it self MUST be abstract.
     */
    public const TYPE_WRAPPER = 'wrapper';

    /**
     * Property value is expected to be a simple json object without defined schema. Whenever possible, a concrete schema SHOULD be defined instead.
     */
    public const TYPE_OBJECT = 'object';

    /**
     * The property value is allowed to be null.
     */
    public const OPTION_NULLABLE = '@nullable';

    /**
     * The property value is not allowed to be empty. Empty values are lists without values, null or empty strings.
     */
    public const OPTION_NOT_EMPTY = '@notEmpty';

    /**
     * The property value MUST be a positive number.
     */
    public const OPTION_POSITIVE = '@positive';

    /**
     * The property value MUST be a negative number.
     */
    public const OPTION_NEGATIVE = '@negative';

    /**
     * The property does contain a key-value-map (object in json), where the key is a unique name for a value.
     */
    public const OPTION_MAP = '@map';

    /**
     * The property does contain a ordered list (array in json) of values.
     */
    public const OPTION_LIST = '@list';

    /**
     * The property does contain an unordered list (array in json) of values.
     */
    public const OPTION_SET = '@set';

    /**
     * The property does contain a key-value map, where the key MUST be a language designator (ISO 639-1).
     */
    public const OPTION_LANGUAGE = '@language';

    /**
     * The property does contain a key-value map, where the key MUST be a language designator (ISO 639-2/T).
     */
    public const OPTION_EXTENDED_LANGUAGE = '@extendedLanguage';

    /**
     * The property does contain a key-value map, where the key MUST be a region designator (ISO 3166-1).
     */
    public const OPTION_LOCALIZED = '@localized';

    /**
     * The property does contain a key-value map, where the key MUST be a script designator (ISO 15924).
     */
    public const OPTION_SCRIPTED = '@scripted';

    /**
     * @return string|null
     */
    public function getContext(): ?string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string[]
     */
    public function getOptions(): array;
}
