#
# Extend table structure for table 'tt_content'
#
CREATE TABLE tt_content
(
    tx_twexercise_cloze_gaps        int(11) unsigned    DEFAULT '0' NOT NULL,
    tx_twexercise_points            float unsigned DEFAULT '0' NOT NULL,
    tx_twexercise_points_multiplier float unsigned DEFAULT '0' NOT NULL
);

#
# Table structure for table 'tx_twexercise_domain_model_cloze'
#
CREATE TABLE tx_twexercise_domain_model_cloze_gap
(
    identifier     varchar(32)         DEFAULT ''  NOT NULL,
    value          text                            NOT NULL,
    is_example     tinyint(4) unsigned DEFAULT '0',
    options        text                            NOT NULL,
    parent_id      int(11) unsigned    DEFAULT 0   NOT NULL,
    parent_table   varchar(255)        DEFAULT ''  NOT NULL,
    parent_sorting int(11)             DEFAULT 0
);
