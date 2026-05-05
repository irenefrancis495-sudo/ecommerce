<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/_auth.php';
require_once __DIR__ . '/_notifications.php';

$adminName = $_SESSION['admin_user']['name'] ?? 'Admin';
$notificationCount = adminNotificationCount();
$activePage = 'categories';
$file = __DIR__ . '/../../data/categories.json';

function readCategories(string $path): array
{
    if (!file_exists($path)) {
        return [];
    }
    $data = json_decode((string) file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

function writeCategories(string $path, array $categories): void
{
    file_put_contents($path, json_encode(array_values($categories), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

function makeSlug(string $name): string
{
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim((string) $slug, '-');
    return $slug ?: 'category';
}

$categories = readCategories($file);
$flash = '';
$flashType = 'success';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) ($_POST['action'] ?? '');

    if ($action === 'add') {
        $name = trim((string) ($_POST['name'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $status = (string) ($_POST['status'] ?? 'active');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if ($name === '') {
            $flash = 'Category name is required.';
            $flashType = 'error';
        } else {
            $newId = 1;
            foreach ($categories as $category) {
                $newId = max($newId, (int) ($category['id'] ?? 0) + 1);
            }

            if ($slug === '') {
                $slug = makeSlug($name);
            }

            $existingSlugs = array_map(static fn($c) => (string) ($c['slug'] ?? ''), $categories);
            if (in_array($slug, $existingSlugs, true)) {
                $slug .= '-' . $newId;
            }

            $categories[] = [
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'sort_order' => $sortOrder,
                'status' => $status === 'inactive' ? 'inactive' : 'active',
                'id' => $newId,
            ];
            writeCategories($file, $categories);
            header('Location: /admin/categories?saved=1');
            exit;
        }
    }

    if ($action === 'update') {
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim((string) ($_POST['name'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $description = trim((string) ($_POST['description'] ?? ''));
        $status = (string) ($_POST['status'] ?? 'active');
        $sortOrder = (int) ($_POST['sort_order'] ?? 0);

        if ($id <= 0 || $name === '') {
            $flash = 'Invalid category update.';
            $flashType = 'error';
        } else {
            foreach ($categories as &$category) {
                if ((int) ($category['id'] ?? 0) !== $id) {
                    continue;
                }
                $category['name'] = $name;
                $category['slug'] = $slug !== '' ? $slug : makeSlug($name);
                $category['description'] = $description;
                $category['sort_order'] = $sortOrder;
                $category['status'] = $status === 'inactive' ? 'inactive' : 'active';
            }
            unset($category);

            writeCategories($file, $categories);
            header('Location: /admin/categories?updated=1');
            exit;
        }
    }

    if ($action === 'delete') {
        $id = (int) ($_POST['id'] ?? 0);
        if ($id > 0) {
            $categories = array_values(array_filter($categories, static fn($c) => (int) ($c['id'] ?? 0) !== $id));
            writeCategories($file, $categories);
            header('Location: /admin/categories?deleted=1');
            exit;
        }
    }
}

if (isset($_GET['saved'])) {
    $flash = 'Category created successfully.';
}
if (isset($_GET['updated'])) {
    $flash = 'Category updated successfully.';
}
if (isset($_GET['deleted'])) {
    $flash = 'Category deleted successfully.';
}
?>
<style>
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 450, 'GRAD' 0, 'opsz' 24; }

  body {
    background:
      radial-gradient(circle at 10% 0%, rgba(20, 184, 166, 0.08) 0%, transparent 30%),
      radial-gradient(circle at 100% 20%, rgba(245, 158, 11, 0.08) 0%, transparent 35%),
      #f5f7fb;
  }

  .admin-shell { position: relative; }
  .admin-shell::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background-image: linear-gradient(rgba(148, 163, 184, 0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(148, 163, 184, 0.06) 1px, transparent 1px);
    background-size: 42px 42px;
    mask-image: radial-gradient(circle at center, black, transparent 78%);
    z-index: 0;
  }

  .surface-glass {
    background: rgba(255, 255, 255, 0.74);
    backdrop-filter: blur(16px);
  }

  .admin-sidebar {
    border-right: 1px solid rgba(255, 255, 255, 0.45);
    box-shadow: 0 24px 40px -32px rgba(15, 23, 42, 0.5);
  }

  .admin-topbar {
    border-bottom: 1px solid rgba(255, 255, 255, 0.7);
    box-shadow: 0 12px 28px -24px rgba(15, 23, 42, 0.35);
  }

  .admin-main { width: calc(100% - 16rem); }
  .admin-content { position: relative; z-index: 1; }

  @media (max-width: 1024px) {
    .admin-sidebar { position: static; width: 100%; height: auto; margin-bottom: 1rem; }
    .admin-topbar { position: static; left: auto; right: auto; width: 100%; margin: 0 1rem 1rem; border-radius: 1rem; }
    .admin-main { width: 100%; margin-left: 0; }
    .admin-content { padding-top: 1.25rem; }
  }
</style>

<div class="admin-shell bg-background text-on-background min-h-screen lg:flex lg:items-start lg:gap-0">
  <?php require_once __DIR__ . '/_sidebar.php'; ?>

  <header class="admin-topbar fixed top-0 left-64 right-0 h-16 bg-white/80 backdrop-blur-xl flex items-center justify-between px-8 z-40 shadow-sm shadow-slate-200/20">
    <h2 class="font-black text-primary text-xl tracking-tight">Category Editor</h2>
    <div class="flex items-center gap-6">
      <a class="relative text-slate-600 hover:text-amber-700 transition-colors" href="/admin/messages" title="Open notifications"><span class="material-symbols-outlined">notifications</span><?php if ($notificationCount > 0): ?><span class="absolute -top-1 -right-1 h-4 min-w-4 px-1 rounded-full bg-red-500 text-white text-[9px] flex items-center justify-center font-bold"><?php echo $notificationCount > 99 ? '99+' : $notificationCount; ?></span><?php endif; ?></a>
      <div class="flex items-center gap-3 pl-4 border-l border-slate-100">
        <img alt="Administrator Profile" class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/80?u=mpemba-admin"/>
        <div class="text-right"><p class="text-xs font-bold text-teal-900"><?php echo htmlspecialchars($adminName); ?></p><p class="text-[10px] text-slate-400">Operations Lead</p></div>
      </div>
    </div>
  </header>

  <main class="admin-main admin-content ml-64 pt-24 p-8 min-h-screen">
    <div class="max-w-6xl mx-auto space-y-8">
      <div>
        <h2 class="text-3xl font-black text-primary tracking-tight flex items-center gap-2">
          <span class="material-symbols-outlined text-3xl" style="font-variation-settings:'FILL' 1">category</span>
          Category Manager
        </h2>
        <p class="text-slate-500 mt-2">Organize products into categories and manage their properties</p>
      </div>

      <?php if ($flash !== ''): ?>
      <div class="px-4 py-3 rounded-lg text-sm font-semibold flex items-center gap-3 <?php echo $flashType === 'error' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-emerald-50 text-emerald-700 border border-emerald-200'; ?>">
        <span class="material-symbols-outlined text-lg" style="font-variation-settings:'FILL' 1"><?php echo $flashType === 'error' ? 'error' : 'check_circle'; ?></span>
        <?php echo htmlspecialchars($flash); ?>
      </div>
      <?php endif; ?>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="flex items-center gap-3 mb-6 pb-5 border-b border-slate-100">
          <div class="w-11 h-11 rounded-lg bg-amber-50 flex items-center justify-center">
            <span class="material-symbols-outlined text-amber-600 text-2xl" style="font-variation-settings:'FILL' 1">add_circle</span>
          </div>
          <div>
            <h3 class="font-black text-primary text-lg">Add New Category</h3>
            <p class="text-xs text-slate-500 mt-0.5">Create a new category for organizing products</p>
          </div>
        </div>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-3">
          <input type="hidden" name="action" value="add" />
          <input class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" type="text" name="name" placeholder="Category name" required />
          <input class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" type="text" name="slug" placeholder="Slug (auto-generated)" />
          <input class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" type="text" name="description" placeholder="Description (optional)" />
          <input class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" type="number" name="sort_order" value="0" placeholder="Sort order" />
          <button class="px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-700 text-white rounded-lg font-bold text-sm shadow-lg shadow-amber-500/20 hover:shadow-xl hover:shadow-amber-500/30 transition-all duration-200 flex items-center justify-center gap-2" type="submit">
            <span class="material-symbols-outlined text-base" style="font-variation-settings:'FILL' 1">add</span>
            Create
          </button>
        </form>
      </section>

      <section class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
          <h3 class="font-black text-primary text-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-600" style="font-variation-settings:'FILL' 1">category</span>
            Existing Categories
          </h3>
          <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold">
            <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">inventory_2</span>
            <?php echo count($categories); ?> total
          </span>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
              <tr>
                <th class="px-6 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Name</th>
                <th class="px-6 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Slug</th>
                <th class="px-6 py-3 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Description</th>
                <th class="px-6 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest">Order</th>
                <th class="px-6 py-3 text-center text-[11px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                <th class="px-6 py-3 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php foreach ($categories as $category): ?>
              <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-4">
                  <form method="POST" class="contents">
                    <input type="hidden" name="action" value="update" />
                    <input type="hidden" name="id" value="<?php echo (int) $category['id']; ?>" />
                    <input class="w-full max-w-xs rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" type="text" name="name" value="<?php echo htmlspecialchars((string) ($category['name'] ?? '')); ?>" required />
                </td>
                <td class="px-6 py-4"><input class="w-full max-w-xs rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-slate-600" type="text" name="slug" value="<?php echo htmlspecialchars((string) ($category['slug'] ?? '')); ?>" /></td>
                <td class="px-6 py-4"><input class="w-full max-w-md rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-slate-600" type="text" name="description" value="<?php echo htmlspecialchars((string) ($category['description'] ?? '')); ?>" /></td>
                <td class="px-6 py-4 text-center"><input class="w-16 text-center rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none" type="number" name="sort_order" value="<?php echo (int) ($category['sort_order'] ?? 0); ?>" /></td>
                <td class="px-6 py-4 text-center">
                  <select name="status" class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none font-semibold">
                    <option value="active" <?php echo (($category['status'] ?? 'active') === 'active') ? 'selected' : ''; ?> class="text-emerald-700">✓ Active</option>
                    <option value="inactive" <?php echo (($category['status'] ?? 'active') === 'inactive') ? 'selected' : ''; ?> class="text-slate-500">○ Inactive</option>
                  </select>
                </td>
                <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                  <button class="px-4 py-2 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-lg text-xs font-bold shadow-lg shadow-teal-500/10 hover:shadow-xl hover:shadow-teal-500/20 transition-all duration-200 flex items-center gap-1.5 inline-flex" type="submit">
                    <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">save</span>
                    Save
                  </button>
                  </form>
                  <form method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                    <input type="hidden" name="action" value="delete" />
                    <input type="hidden" name="id" value="<?php echo (int) $category['id']; ?>" />
                    <button class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold border border-red-100 hover:bg-red-100 hover:text-red-700 transition-colors duration-200 flex items-center gap-1.5" type="submit">
                      <span class="material-symbols-outlined text-sm" style="font-variation-settings:'FILL' 1">delete</span>
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php if (empty($categories)): ?>
        <div class="px-6 py-12 text-center">
          <span class="material-symbols-outlined text-5xl text-slate-300 mb-3 inline-block">category</span>
          <p class="text-slate-500 font-medium">No categories yet. Create one to get started!</p>
        </div>
        <?php endif; ?>
      </section>
    </div>
  </main>
</div>
