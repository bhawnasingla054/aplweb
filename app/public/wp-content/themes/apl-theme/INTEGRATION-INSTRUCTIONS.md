# Team/Advisors Section Integration Instructions

## Overview
The People section (Team/Advisors) has been fully implemented. However, due to the complex Framer-exported structure of front-page.php, you need to manually add one line to integrate it.

## What's Been Completed

✅ Custom Post Type `apl_person` registered
✅ Taxonomy `apl_person_group` (Team/Advisors) created
✅ Meta fields (Role, LinkedIn) added
✅ WordPress Admin metabox created
✅ Customizer settings added ("Homepage – People")
✅ Template part created ([template-parts/home-people.php](template-parts/home-people.php))
✅ CSS stylesheet created ([assets/css/people.css](assets/css/people.css))
✅ JavaScript for tab toggle created ([assets/js/people-toggle.js](assets/js/people-toggle.js))
✅ Assets enqueued for front page only

## Manual Integration Required

### Step 1: Locate the Team Section in front-page.php

Open [front-page.php](front-page.php) and find where you want the Team section to appear. This should be:
- **After** the Product Overview section
- **Before** the Partners/Footer section

### Step 2: Add the Template Part

Insert the following code at the desired location:

```php
<!-- APL: PEOPLE SECTION START -->
<?php get_template_part('template-parts/home-people'); ?>
<!-- APL: PEOPLE SECTION END -->
```

**Important**:
- Do NOT modify any surrounding Framer HTML markup
- Just insert these 3 lines at the appropriate location
- The comments help identify the section for future reference

### Example Integration

If you have a structure like this in front-page.php:

```html
... Product Overview Section ...
</section>

<!-- Insert People section here -->

<section aria-label="Partners" ...>
... Partners Section ...
```

It should become:

```html
... Product Overview Section ...
</section>

<!-- APL: PEOPLE SECTION START -->
<?php get_template_part('template-parts/home-people'); ?>
<!-- APL: PEOPLE SECTION END -->

<section aria-label="Partners" ...>
... Partners Section ...
```

## How to Use After Integration

### 1. Access the People Admin

Go to: **WP Admin → People** (in the sidebar)

### 2. Create Person Groups (One-Time Setup)

Before adding people, create the groups:

1. Go to **People → Groups**
2. Create two groups:
   - **team** (slug: `team`)
   - **advisors** (slug: `advisors`)

### 3. Add Team Members

1. Click **People → Add New**
2. Enter the person's **Name** (Title field)
3. Set **Featured Image** (their photo - this is required)
4. In the **Person Details** metabox:
   - Enter **Role/Title** (e.g., "CEO", "Advisor", "Engineer") - required
   - Enter **LinkedIn URL** (optional - makes card clickable)
5. Select **Group**: Check either "team" or "advisors"
6. Set **Order** (optional): Use the "Order" field to control display order
7. Click **Publish**

### 4. Configure Display Settings

Go to: **Appearance → Customize → Homepage – People**

**Settings Available:**
- **Section Title**: Default is "Team" - change as needed
- **Enable Advisors Tab**: Check to show both Team and Advisors with pill toggle
- **Default Tab**: Choose which tab shows first (Advisors or Team)

### 5. Behavior Rules

- **If Advisors disabled**: Only "Team" members show, no pills/tabs
- **If Advisors enabled but no advisors exist**: Only "Team" members show, no pills
- **If Advisors enabled and advisors exist**: Both tabs show with pill toggle
- **Cards only show if**: Person has Name + Role + Photo (all three required)
- **Cards are clickable only if**: LinkedIn URL is provided

## File Locations for Customization

| What to Customize | File | Lines |
|-------------------|------|-------|
| Section Title, Enable Advisors, Default Tab | **Appearance → Customize → Homepage – People** | N/A (GUI) |
| Card Styling (colors, spacing, hover) | [assets/css/people.css](assets/css/people.css) | 45-78 |
| Grid Layout (columns) | [assets/css/people.css](assets/css/people.css) | 40-42, 117-121 |
| Pill/Tab Styling | [assets/css/people.css](assets/css/people.css) | 25-38 |
| Responsive Breakpoints | [assets/css/people.css](assets/css/people.css) | 110-177 |
| Query Logic (how members are fetched) | [template-parts/home-people.php](template-parts/home-people.php) | 18-90 |
| HTML Structure | [template-parts/home-people.php](template-parts/home-people.php) | 108-197 |

## Styling Notes

The People section uses:
- **Clean, minimal design** matching your theme
- **Responsive grid**: 3 columns → 2 columns → 1 column
- **Horizontal cards** with circular avatar on left, info on right
- **Subtle hover effects**: Border darkens, card lifts slightly
- **Accessible**: Proper ARIA attributes, semantic HTML

## Testing Checklist

After integration, test:

- [ ] Section appears on front page
- [ ] Add a Team member with photo + role → appears
- [ ] Add an Advisor with photo + role → doesn't show yet
- [ ] Enable "Advisors Tab" in Customizer → now shows pills
- [ ] Click between Team/Advisors pills → content switches
- [ ] Add LinkedIn URL → card becomes clickable, opens in new tab
- [ ] Remove photo from a member → that member disappears
- [ ] Test on mobile → stacks to single column
- [ ] Test with no Team members → section disappears entirely

## Troubleshooting

**Section doesn't appear:**
- Check that you added the template part to front-page.php
- Ensure at least one Team member exists with Name + Role + Photo

**Advisors tab doesn't show:**
- Check "Enable Advisors Tab" in Customizer
- Ensure at least one Advisor exists with Name + Role + Photo

**Cards look broken:**
- Clear browser cache
- Check that people.css is loading (View Source → search for "people.css")

**Pills don't switch:**
- Check browser console for JS errors
- Ensure people-toggle.js is loading

## Support

All code is fully documented with comments. The implementation follows WordPress best practices and is 100% CMS-driven with no hardcoded content.
