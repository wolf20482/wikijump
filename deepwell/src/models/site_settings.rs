//! SeaORM Entity. Generated by sea-orm-codegen 0.6.0

use sea_orm::entity::prelude::*;
use serde::{Deserialize, Serialize};

#[derive(Clone, Debug, PartialEq, DeriveEntityModel, Serialize, Deserialize)]
#[sea_orm(table_name = "site_settings")]
pub struct Model {
    #[sea_orm(primary_key, auto_increment = false)]
    pub site_id: i32,
    pub allow_membership_by_apply: bool,
    pub allow_membership_by_password: bool,
    pub membership_password: Option<String>,
    pub file_storage_size: i32,
    pub use_ganalytics: bool,
    pub private_landing_page: String,
    pub max_private_members: i32,
    pub max_private_viewers: i32,
    pub hide_navigation_unauthorized: bool,
    pub ssl_mode: Option<String>,
    pub allow_members_invite: bool,
    pub max_upload_file_size: i32,
}

#[derive(Copy, Clone, Debug, EnumIter, DeriveRelation)]
pub enum Relation {
    #[sea_orm(
        belongs_to = "super::site::Entity",
        from = "Column::SiteId",
        to = "super::site::Column::SiteId",
        on_update = "Cascade",
        on_delete = "Cascade"
    )]
    Site,
}

impl Related<super::site::Entity> for Entity {
    fn to() -> RelationDef {
        Relation::Site.def()
    }
}

impl ActiveModelBehavior for ActiveModel {}
