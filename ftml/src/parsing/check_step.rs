/*
 * parsing/check_step.rs
 *
 * ftml - Library to parse Wikidot text
 * Copyright (C) 2019-2022 Wikijump Team
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

use super::{ExtractedToken, ParseWarning, Parser, Token};

/// Helper function to assert that the current token matches, then step.
///
/// # Returns
/// The `ExtractedToken` which was checked and stepped over.
///
/// # Panics
/// Since an assert is used, this function will panic
/// if the extracted token does not match the one specified.
#[inline]
pub fn check_step<'r, 't>(
    parser: &mut Parser<'r, 't>,
    token: Token,
) -> Result<&'r ExtractedToken<'t>, ParseWarning> {
    let current = parser.current();

    assert_eq!(current.token, token, "Opening token isn't {}", token.name());

    parser.step()?;

    Ok(current)
}

#[test]
#[should_panic]
fn check_step_fail() {
    use crate::data::PageInfo;
    use crate::settings::{WikitextMode, WikitextSettings};

    let page_info = PageInfo::dummy();
    let settings = WikitextSettings::from_mode(WikitextMode::Page);
    let tokenization = crate::tokenize("**Apple** banana");
    let mut parser = Parser::new(&tokenization, &page_info, &settings);

    let _ = check_step(&mut parser, Token::Italics);
}
