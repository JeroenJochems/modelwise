# Model Finder - Requirements Document

## Overview

A new admin tool that enables fast, intelligent discovery of model profiles for casting. The tool combines AI-powered photo analysis, semantic search, and visual similarity matching to help admins find the right talent for any gig.

---

## 1. AI Photo Descriptions & Embeddings

### 1.1 Photo Analysis Enhancement

**IRNORE THE CURRENT ANALYSIS:** Photos are analyzed via GPT-4 Vision, producing JSON metadata (descent, skin color, hair details, clothing, etc.) stored in `photos.analysis`.

**Required enhancements:**

| Requirement | Description                                                                                |
|-------------|--------------------------------------------------------------------------------------------|
| REQ-1.1.1 | Generate rich descriptions for each photo                                                  |
| REQ-1.1.2 | Descriptions must capture: personal characteristics, style tags, overall mood, brand vibes |
| REQ-1.1.3 | Descriptions should be consistent in format to enable meaningful comparisons               |
| REQ-1.1.4 | Store descriptions, replacing the current analysis.                                        |

### 1.2 Vector Embeddings

| Requirement | Description                                                                                            |
|-------------|--------------------------------------------------------------------------------------------------------|
| REQ-1.2.1 | Generate vector embeddings from photo descriptions + model characteristics using OpenAI embeddings API |
| REQ-1.2.2 | Store embeddings in PlanetScale vector store                                                           |
| REQ-1.2.3 | Create composite "model embedding" by aggregating/averaging a model's photo embeddings                 |
| REQ-1.2.4 | Re-generate model embedding when photos are added/removed                                              |
| REQ-1.2.5 | Support batch processing for existing photo backlog                                                    |
| REQ-1.2.6 | Queue-based processing to avoid blocking operations                                                    |

### 1.3 Vibe/Aesthetic Matching

| Requirement | Description                                                                         |
|-------------|-------------------------------------------------------------------------------------|
| REQ-1.3.1 | Make a simple interface in which we can test if searching yields meaningful results |
| REQ-1.3.2 | Implement a simple feature so verify if similarity search yields meaningful results |

---

## 2. Search Interface

### 2.1 Natural Language Search

| Requirement | Description                                                                                            |
|-------------|--------------------------------------------------------------------------------------------------------|
| REQ-2.1.1   | Text input for natural language queries ("tall blonde with edgy streetwear vibe, tommy hilfiger vibe") |
| REQ-2.1.2   | Query converted to embedding and matched against model embeddings                                      |
| REQ-2.1.3   | Results ranked by similarity score                                                                     |
| REQ-2.1.4   | Support combining text search with attribute filters (age range, height, gender)                       |

### 2.2 Image-Based Search

| Requirement | Description |
|-------------|-------------|
| REQ-2.2.1 | Admin can upload a reference image (photo, mood board, brand example) |
| REQ-2.2.2 | System generates description of uploaded image via AI |
| REQ-2.2.3 | System creates embedding from description |
| REQ-2.2.4 | Match against model embeddings by vibe/aesthetic similarity |
| REQ-2.2.5 | Support multiple reference images to define a "look" |
| REQ-2.2.6 | Reference images are temporary, not persisted |

### 2.3 Search Results Display

| Requirement | Description |
|-------------|-------------|
| REQ-2.3.1 | Grid view of model cards with primary photo |
| REQ-2.3.2 | Show similarity score/relevance indicator |
| REQ-2.3.3 | Quick preview: hover or click to see more photos |
| REQ-2.3.4 | Pagination or infinite scroll |
| REQ-2.3.5 | Results selectable (multi-select for batch operations) |

---

## 3. Role Assignment Workflow

### 3.1 Active Searches / Workspaces

| Requirement | Description |
|-------------|-------------|
| REQ-3.1.1 | Each admin has their own workspace with active searches tied to roles |
| REQ-3.1.2 | Active searches displayed as drop zones in the interface |
| REQ-3.1.3 | Each active search shows: role name, job name, current model count |
| REQ-3.1.4 | Active searches persist across sessions |
| REQ-3.1.5 | Admins can view other admins' workspaces (read-only) |
| REQ-3.1.6 | Indicator showing which admin owns a workspace |

### 3.2 Drag-and-Drop to Roles

| Requirement | Description |
|-------------|-------------|
| REQ-3.2.1 | Models can be dragged from search results to an active search/role |
| REQ-3.2.2 | On drop, prompt admin to choose: "List" or "Invite" |
| REQ-3.2.3 | "List" creates a Listing without notification |
| REQ-3.2.4 | "Invite" creates a Listing and sends invitation email |
| REQ-3.2.5 | Option to shortlist immediately when inviting |
| REQ-3.2.6 | Support dropping multiple selected models at once |
| REQ-3.2.7 | Visual feedback: indicate if model already in role |

---

## 4. Tagging Workflow

### 4.1 Drag-and-Drop to Tags

| Requirement | Description |
|-------------|-------------|
| REQ-4.1.1 | Tag panel visible in interface showing existing tags |
| REQ-4.1.2 | Tags filterable/searchable by type (Looks, Skills, Internal, etc.) |
| REQ-4.1.3 | Models can be dragged to tags |
| REQ-4.1.4 | Support creating new tags inline |
| REQ-4.1.5 | Support dropping multiple selected models at once |
| REQ-4.1.6 | Visual feedback: indicate if model already has tag |

### 4.2 Tag Suggestions

| Requirement | Description |
|-------------|-------------|
| REQ-4.2.1 | Based on AI photo analysis, suggest relevant tags for a model |
| REQ-4.2.2 | Suggestions shown when model is selected |
| REQ-4.2.3 | One-click to apply suggested tags |

---

## 5. AI Role Creation

### 5.1 Role Generation from Input

| Requirement | Description |
|-------------|-------------|
| REQ-5.1.1 | Admin can upload: brief text, reference images, mood board |
| REQ-5.1.2 | AI generates structured role description from inputs |
| REQ-5.1.3 | Generated output includes: role title, description, requirements, ideal look |
| REQ-5.1.4 | Admin can edit generated content before saving |
| REQ-5.1.5 | Save creates a new Role record |

### 5.2 Search Seeding

| Requirement | Description |
|-------------|-------------|
| REQ-5.2.1 | After role creation, automatically generate search query from role content |
| REQ-5.2.2 | Pre-populate search results as starting point |
| REQ-5.2.3 | Reference images from role creation can seed image-based search |

---

## 6. Non-Functional Requirements

### 6.1 Performance

| Requirement | Description |
|-------------|-------------|
| REQ-6.1.1 | Search results returned in < 500ms |
| REQ-6.1.2 | Image upload + embedding generation < 3s |
| REQ-6.1.3 | Drag-drop operations feel instant (< 100ms feedback) |
| REQ-6.1.4 | Support 10+ concurrent admin users |

### 6.2 Data

| Requirement | Description |
|-------------|-------------|
| REQ-6.2.1 | Embeddings stored in PlanetScale vector store |
| REQ-6.2.2 | Embedding dimension compatible with OpenAI ada-002 (1536) or text-embedding-3-small (1536) |
| REQ-6.2.3 | Batch job to backfill embeddings for existing photos |
| REQ-6.2.4 | Incremental updates when new photos added |

### 6.3 Access Control

| Requirement | Description |
|-------------|-------------|
| REQ-6.3.1 | Only authenticated admin users can access |
| REQ-6.3.2 | Use existing Laravel authentication |
| REQ-6.3.3 | Audit log for role assignments made via this tool |

---

## 7. User Stories

### Search & Discovery
- As an admin, I want to describe the look I need in plain language so I can quickly find matching models
- As an admin, I want to upload a reference photo to find models with a similar vibe/aesthetic
- As an admin, I want to upload mood board images to define a "look" and find matching models
- As an admin, I want to combine text and image search to narrow results precisely

### Role Assignment
- As an admin, I want to drag models to a role so I can quickly build a shortlist
- As an admin, I want to choose between listing and inviting when adding a model so I control their notification
- As an admin, I want to see which models are already in a role so I don't add duplicates

### Tagging
- As an admin, I want to drag models to tags while browsing so I can improve future searches
- As an admin, I want AI to suggest tags based on photos so tagging is faster

### Role Creation
- As an admin, I want to create a role by uploading a brief and images so I don't have to write everything manually
- As an admin, I want the new role to automatically seed a search so I can start finding models immediately

---

## 8. Out of Scope (v1)

- Model self-service (this is admin-only)
- Video analysis and embedding
- Real-time collaboration between admins
- Mobile-optimized interface
- Public API access

---


## 10. Dependencies

- PlanetScale vector store add-on (to be provisioned)
- OpenAI Embeddings API access (text-embedding-3-small or ada-002)
- OpenAI GPT-4 Vision API (for image description generation)
