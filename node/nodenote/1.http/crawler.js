// 小爬虫
const https = require('https');
let url = 'https://www.imooc.com/learn/348'

let cheerio = require('cheerio') // cnpm i -g cheerio

let filterChapters = html => {
  let $ = cheerio.load(html)
  let chapters = $('.chapter')
  let courseData = [];

  chapters.each(function(item){
    let chapter = $(this);
    let chapterTitle = chapter.find('strong').text().replace(/\n/g, '').replace(/\s+/g, ' ');

    let chapterSections = [];
    let videos = chapter.find('.video').children('li').each(function(item){
      let video = $(this).find('.J-media-item');
      let title = video.text().replace(/\n/g, '').replace(/\s+/g, ' ');
      let id = video.attr('href').split('video/')[1]
      chapterSections.push({
        title,
        id
      })
    });

    let chapterData = {
      chapterTitle,
      chapterSections
    }

    courseData.push(chapterData)
  })

  return courseData
}

let printCourseInfo = courseData => {
  courseData.forEach((item)=>{
    console.log(item.chapterTitle + '\n');
    item.chapterSections.forEach((section)=>{
      console.log('    [' + section.id + ']' + section.title + '\n')
    })
  })
}


https.get(url, res => {
  let html = '';

  res.on('data', data => {
    html += data
  })

  res.on('end', ()=>{
    // console.log(html)
    let courseData = filterChapters(html)
    printCourseInfo(courseData)
  })

}).on('error', err => {
  console.log('爬取失败')
})