<form id="add-movie-form">
    <label for="title">ชื่อเรื่อง:</label>
    <input type="text" id="title" name="title" required>

    <label for="category">หมวดหมู่:</label>
    <select id="category" name="category">
        <option value="action">Action</option>
        <option value="drama">Drama</option>
        <option value="comedy">Comedy</option>
        <!-- เพิ่มหมวดหมู่เพิ่มเติมที่ต้องการ -->
    </select>

    <label for="description">รายละเอียด:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="coverImage">รูปภาพปก:</label>
    <input type="file" id="coverImage" name="coverImage" accept="image/*">

    <label for="trailer">วิดีโอตัวอย่าง:</label>
    <input type="file" id="trailer" name="trailer" accept="video/*">

    <button type="submit">บันทึก</button>
</form>
