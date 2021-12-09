//! SeaORM Entity. Generated by sea-orm-codegen 0.4.1

use sea_orm::entity::prelude::*;

#[derive(Clone, Debug, PartialEq, DeriveEntityModel)]
#[sea_orm(table_name = "ozone_user_permission_modifier")]
pub struct Model {
    #[sea_orm(primary_key)]
    pub user_permission_id: i64,
    pub user_id: Option<i32>,
    pub permission_id: Option<String>,
    pub modifier: Option<i32>,
}

#[derive(Copy, Clone, Debug, EnumIter)]
pub enum Relation {}

impl RelationTrait for Relation {
    fn def(&self) -> RelationDef {
        panic!("No RelationDef")
    }
}

impl ActiveModelBehavior for ActiveModel {}
