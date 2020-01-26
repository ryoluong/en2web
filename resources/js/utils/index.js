export default {
  getUserImagePath: user => {
    return user.avater_path ? user.avater_path : '/img/categories/user.png';
  },
  getNoteImagePath: note => {
    return note.photos.length
      ? note.photos[0]['path']
      : `/img/note_cover_photo/${note.category_id}.jpg`;
  },
};
