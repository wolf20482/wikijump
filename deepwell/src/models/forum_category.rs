//! SeaORM Entity. Generated by sea-orm-codegen 0.6.0

use sea_orm::entity::prelude::*;
use serde::{Deserialize, Serialize};

#[derive(Clone, Debug, PartialEq, DeriveEntityModel, Serialize, Deserialize)]
#[sea_orm(table_name = "forum_category")]
pub struct Model {
    #[sea_orm(primary_key)]
    pub category_id: i64,
    pub group_id: Option<i32>,
    pub name: Option<String>,
    pub description: Option<String>,
    pub number_posts: i32,
    pub number_threads: i32,
    pub last_post_id: Option<i32>,
    pub permissions_default: bool,
    pub permissions: Option<String>,
    pub max_nest_level: Option<i32>,
    pub sort_index: i32,
    pub site_id: Option<i32>,
    pub per_page_discussion: bool,
}

#[derive(Copy, Clone, Debug, EnumIter, DeriveRelation)]
pub enum Relation {
    #[sea_orm(
        belongs_to = "super::forum_group::Entity",
        from = "Column::GroupId",
        to = "super::forum_group::Column::GroupId",
        on_update = "Cascade",
        on_delete = "Restrict"
    )]
    ForumGroup,
    #[sea_orm(
        belongs_to = "super::forum_post::Entity",
        from = "Column::LastPostId",
        to = "super::forum_post::Column::PostId",
        on_update = "Cascade",
        on_delete = "SetNull"
    )]
    ForumPost,
    #[sea_orm(
        belongs_to = "super::site::Entity",
        from = "Column::SiteId",
        to = "super::site::Column::SiteId",
        on_update = "Cascade",
        on_delete = "Cascade"
    )]
    Site,
    #[sea_orm(has_many = "super::forum_thread::Entity")]
    ForumThread,
}

impl Related<super::forum_group::Entity> for Entity {
    fn to() -> RelationDef {
        Relation::ForumGroup.def()
    }
}

impl Related<super::forum_post::Entity> for Entity {
    fn to() -> RelationDef {
        Relation::ForumPost.def()
    }
}

impl Related<super::site::Entity> for Entity {
    fn to() -> RelationDef {
        Relation::Site.def()
    }
}

impl Related<super::forum_thread::Entity> for Entity {
    fn to() -> RelationDef {
        Relation::ForumThread.def()
    }
}

impl ActiveModelBehavior for ActiveModel {}
