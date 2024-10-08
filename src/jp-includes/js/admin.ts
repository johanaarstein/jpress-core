const request = new XMLHttpRequest()

//BLEND HACK
// if (document.getElementsByClassName('admin').length > 0) {
//   document.documentElement.classList.add('blend')
// }

//GLOBAL VARIABLES
const formData = new FormData()

const moduleMessage = document.getElementById('module-message')
const message = document.getElementById('message')
const messageSuccess = document.getElementById('success')
const messageFailure = document.getElementById('failure')
const messageDeleted = document.getElementById('deleted')
const chooseImage = document.getElementById('choose-image')

const published = document.getElementById('published')
const pageLabel = document.getElementById('article-label')
const displayInMenu = document.getElementById('display-in-menu')

const mediaLibrary = document.getElementById('media-library-view')
const imageDetails = document.getElementById('image-details')
const imageDetailsForm = document.getElementById('image-details-form')
const fileNameText = document.getElementById('filename')
const fileNameInput = document.getElementById('filename-input')
const fileSizeText = document.getElementById('filesize')
const copyUrl = document.getElementById('copyurl')
const imageAlt = document.getElementById('module-image-alt')
const photoCredit = document.getElementById('module-photo-credit')
const copyTooltip = document.getElementById('copy-tooltip')
const selectedMedia = document.getElementById('selected-media')
const captionSwitch = document.getElementById('caption-switch')
const captionInput = document.getElementById('caption-input')

let moduleLinks = document.getElementsByClassName('module-link')
const _module = document.getElementsByClassName('module')[1]
const ytModule = document.getElementById('embed-youtube')
const moduleClose = document.getElementById('close-module')
const imgSaveBtn = document.getElementById('save-image-details')
// const saveBtn = document.getElementById('save-changes')

const adminPanelButton = document.getElementById('adminpanelbutton')
const adminPanel = document.getElementById('admin-menu-wrapper')
const loginModule = document.getElementById('module-login')

const featuredImageInput = document.getElementById('featured-image-input')
const featuredImageElement = document.getElementById('featured-image-element')
const featuredImageId = document.getElementById('featured-image-id')
const displayImage = document.getElementById('display-image')

const spinnerImage = document.getElementById('spinner-image')

let moduleLink
let deleteInput
let moduleLinksArray
let selectedMediaThumb
let featuredImageContainer

let featuredImageMenu
let imageSaveContainer
let imageInstructions
let initialImagePosition

let _index
let nextItem
let previousItem
let newAlt
let newCredit
let newCaption

let public_str: string
let unpublish_str: string
let draft_str: string
let publish_str: string
let displayInMenu_str: string
let hideFromMenu_str: string

//LANGUGE
let thereWasAnError
let theUploadSucceeded
let thisFileTypeIsNotAllowed
let yourAboutToDeleteThisFilePermanently
let yourAboutToDeleteThisUserPermanently
let yourAboutToDeleteThisArticlePermanently
let yourAboutToDeleteThisSectionPermanently
let saved_str: string
let dragToMove
let uploadImage_str: string
let copied_str: string
let copyLink_str: string
let fileTooBig
let deleted_str: string
let mapMessageText
let added_str: string
let headline_str: string
let youHaveChangedUrl
let pwdNoMatch_str: string
let newUser_str: string
let noFormsSelected_str
let updated_str: string
let alreadyUpdated_str
if (siteLang === 'no') {
  alreadyUpdated_str = 'Du har den nyeste versjonen'
  thereWasAnError = 'Det skjedde en feil'
  theUploadSucceeded = 'Opplastingen var vellykket!'
  thisFileTypeIsNotAllowed = 'Denne filtypen er ikke tillatt, eller filen er skadet'
  yourAboutToDeleteThisFilePermanently = 'Du er i ferd med å slette denne fila permanent. Er du sikker?'
  yourAboutToDeleteThisUserPermanently = 'Du er i ferd med å slette denne brukeren permanent. Er du sikker?'
  yourAboutToDeleteThisArticlePermanently = 'Du er i ferd med å slette denne artikkelen permanent. Er du sikker?'
  yourAboutToDeleteThisSectionPermanently = 'Du er i ferd med å slette denne seksjonen permanent. Er du sikker?'
  dragToMove = 'Dra for å flytte bildet'
  saved_str = 'Lagret'
  uploadImage_str = 'Last opp bilde'
  copied_str = 'Kopiert'
  copyLink_str = 'Kopier lenke'
  fileTooBig = 'Fila var for stor'
  deleted_str = 'Slettet'
  mapMessageText = 'Kartet kunne ikke lastes.'
  added_str = 'Lagt til'
  headline_str = 'Overskrift'
  youHaveChangedUrl = 'Du er i ferd med å endre URL\'en. Husk å lage redirects dersom du vil beholde trafikken til den opprinnelige adressen'
  pwdNoMatch_str = 'Passordene du skrev inn stemte ikke overens.'
  newUser_str = 'Ny bruker lagt til'
  public_str = 'Offentlig'
  unpublish_str = 'Avpubliser'
  draft_str = 'Utkast'
  publish_str = 'Publiser'
  displayInMenu_str = 'Vis i meny'
  hideFromMenu_str = 'Gjem fra meny'
  noFormsSelected_str = 'Ingen tekstfelt valgt for lagring'
  updated_str = 'Great success! JPress er oppdatert.'
} else if (siteLang === 'en') {
  alreadyUpdated_str = 'You have the newest version'
  thereWasAnError = 'There was an error'
  theUploadSucceeded = 'The upload succeeded!'
  thisFileTypeIsNotAllowed = 'This file type is not allowed, or your file is damaged'
  yourAboutToDeleteThisFilePermanently = 'You\'re about to delete this file permanently. Are you sure?'
  yourAboutToDeleteThisUserPermanently = 'You\'re about to delete this user permanently. Are you sure?'
  yourAboutToDeleteThisArticlePermanently = 'You\'re about to delete this article permanently. Are you sure?'
  yourAboutToDeleteThisSectionPermanently = 'You\'re about to delete this section permanently. Are you sure?'
  dragToMove = 'Drag to move image'
  saved_str = 'Saved'
  uploadImage_str = 'Upload Image'
  copied_str = 'Copied'
  copyLink_str = 'Copy link'
  fileTooBig = 'The file was too big'
  deleted_str = 'Deleted'
  mapMessageText = 'The map could not be loaded.'
  added_str = 'Added'
  headline_str = 'Headline'
  youHaveChangedUrl = 'You\'re about to change the URL. Remember to set up redirects if you want to keep the traffic from the old address.'
  pwdNoMatch_str = 'The passwords did not match.'
  newUser_str = 'New user added'
  public_str = 'Pulic'
  unpublish_str = 'Unpublish'
  draft_str = 'Draft'
  publish_str = 'Publish'
  displayInMenu_str = 'Show in menu'
  hideFromMenu_str = 'Hide from menu'
  noFormsSelected_str = 'No textfield chosen for save'
  updated_str = 'Great success! JPress is updated.'
}

//Update CMS
document.getElementById('get-updates')?.addEventListener('click', e => {
  e.preventDefault()
  const requestString = 'update-core'
  dbQuery(requestString, '/jp-includes/update/update-core.php', 'application/x-www-form-urlencoded', messageSuccess, updated_str, false, window.location.href)
})

function isHome() {
  let flag = false
  if (document.getElementsByClassName('home').length > 0) {
    flag = true
  }
  return flag
}

function isArticle() {
  let flag = false
  if (document.getElementsByClassName('article').length > 0) {
    flag = true
  }
  return flag
}

function isSettings() {
  let flag = false
  if (document.getElementsByClassName('seo-panel').length > 0) {
    flag = true
  }
  return flag
}

function queryStringToJSON(qs) {
  qs = qs || location.search.slice(1)
  var pairs = qs.split('&')
  var result = {}
  pairs.forEach(function (p) {
    var pair = p.split('=')
    var key = pair[0]
    var value = decodeURIComponent(pair[1] || '')
    if (result[key]) {
      if (Object.prototype.toString.call(result[key]) === '[object Array]') {
        result[key].push(value)
      } else {
        result[key] = [result[key], value]
      }
    } else {
      result[key] = value
    }
  })
  return JSON.parse(JSON.stringify(result))
}

//DATABASE QUERY FUNCTION
function dbQuery(reqStr, postUrl, contentType, successIcon, successMsg, callbackObject, redirect) {
  return new Promise((resolve, reject) => {
    spinnerGlobal.style.display = 'block'
    spinnerGlobal.style.opacity = '1'
    request.open('POST', postUrl, true)
    request.setRequestHeader('Content-Type', contentType + ' charset=UTF-8')
    request.onreadystatechange = function () {
      spinnerGlobal.style.display = 'none'
      spinnerGlobal.style.opacity = '0'
      message.innerText = ''
      successIcon.style.display = messageFailure.style.display = 'none'
      fadeIn(moduleMessage, 2)
      if (this.readyState === 4) {
        if (this.status >= 200 && this.status < 302) {
          if (this.status >= 200 && this.status !== (201 || 204) && this.status < 300) {
            message.innerText = successMsg
            successIcon.style.display = 'block'
            if (redirect) {
              let action
              if (window.location.href === redirect) {
                setTimeout(function () {
                  location.reload()
                }, 1400)
              } else {
                setTimeout(function () {
                  window.location = redirect
                }, 1400)
              }
            }
          } else if (this.status === 302) {
            //For testing
            message.innerText = this.responseText
            console.log(this.responseText)
          } else if (this.status === 201) {
            Object.assign(callbackObject, JSON.parse(this.responseText))
            message.innerText = successMsg
            successIcon.style.display = 'block'
          } else if (this.status === 204) {
            message.innerText = alreadyUpdated_str
            successIcon.style.display = 'block'
          }
        } else if (this.status >= 400 && this.status < 600) {
          if (this.responseText !== '') {
            message.innerHTML = this.responseText
          } else {
            message.innerHTML = thereWasAnError
          }
          console.log(this.responseText)
          messageFailure.style.display = 'block'
        }
        setTimeout(function () {
          fadeOut(moduleMessage, 2)
        }, 1500)
        setTimeout(function () {
          message.innerText = ''
          successIcon.style.display = messageFailure.style.display = 'none'
        }, 6000)
      }
      resolve(callbackObject)
    }
    request.send(reqStr)
  })
}

//REMOVE LISTENER ON CLASS CHANGE
function changeFunction(el, _event, _function, newFunction, _parent, _class) {
  const config = { attributes: true }
  const callback = function (mutationsList, observer) {
    for (let mutation of mutationsList) {
      if (mutation.type === 'attributes') {
        if (_parent.classList.contains(_class)) {
          el?.removeEventListener(_event, _function, true)
          el?.addEventListener(_event, newFunction, true)
        } else {
          el?.addEventListener(_event, _function, true)
          el?.removeEventListener(_event, newFunction, true)
        }
      }
    }
  }
  const observer = new MutationObserver(callback)
  observer.observe(_parent, config)
  return false
}

//TRUNCATE STRING
function truncateString(str, num) {
  // let ext = ('.jpg' || '.png' || '.pdf' || '.svg')
  if (str.length <= num + 3) {
    return str
  }
  if (str.includes('.jpg')) {
    return str.slice(0, num) + '...jpg'
  } else if (str.includes('.png')) {
    return str.slice(0, num) + '...png'
  } else if (str.includes('.pdf')) {
    return str.slice(0, num) + '...pdf'
  } else if (str.includes('.svg')) {
    return str.slice(0, num) + '...svg'
  } else {
    return str.slice(0, num) + '...'
  }
}

//DRAG FUNCTION
let abortDrag = false
const imagePositionInput = document.getElementById('image-position-input')

function dragElement(el) {
  let pos1 = 0, pos2 = 0
  el.onmousedown = dragMouseDown

  function dragMouseDown(e) {
    if (abortDrag === false) {
      e = e || window.event
      e.preventDefault()
      pos2 = e.clientY
      document.onmouseup = closeDragElement
      document.onmousemove = elementDrag
    }
  }

  function elementDrag(e) {
    let imgWidth
    let imgHeight
    let imgFrameHeight
    if (abortDrag === false) {
      e = e || window.event
      e.preventDefault()
      pos1 = pos2 - e.clientY
      pos2 = e.clientY
      imgWidth = el.clientWidth
      imgHeight = el.clientHeight
      imgFrameHeight = ((imgWidth * 0.8) * 0.7)
      let elPos = el.offsetTop - pos1
      if (elPos < 0) {
        el.style.top = elPos + 'px'
        if ((imgHeight + elPos) < imgFrameHeight) {
          el.style.top = 0 - (imgHeight - imgFrameHeight) + 'px'
        }
      } else {
        el.style.top = '0'
      }
      if (imagePositionInput) {
        imagePositionInput.value = elPos
      }
    }
  }

  function closeDragElement() {
    document.onmouseup = null
    document.onmousemove = null
  }
}

//ENABLE IMAGE DRAG
function openDragUI() {
  imageInstructions.innerHTML = dragToMove
  featuredImageContainer.style.cursor = 'move'
  featuredImageMenu.style.display = 'none'
  imageSaveContainer.style.display = 'block'
  imageInstructions.style.display = 'block'
  imageInstructions.style.opacity = '1'
  if (selectedMedia.querySelector('img').dataset.id) {
    featuredImageElement.dataset.id = selectedMedia.querySelector('img').dataset.id
  }
  featuredImageElement.style.transform = 'translateY(0)'
  featuredImageElement.style.top = (initialImagePosition * featuredImageElement.clientHeight) / 100 + 'px'
  abortDrag = false
  imagePositionInput.dataset.edited = true
  dragElement(featuredImageElement)
  setTimeout(function () {
    fadeOut(imageInstructions, 2)
  }, 3000)
}

//DISABLE IMAGE DRAG
function closeDragUI() {
  featuredImageContainer.classList.remove('menu-open')
  abortDrag = true
  imageSaveContainer.style.display = imageInstructions.style.display = 'none'
  featuredImageMenu.style.display = 'block'
  featuredImageContainer.style.cursor = 'pointer'
}

//MENU DRAG
let dragSrcEl
function dragStart(e) {
  dragSrcEl = this
  e.dataTransfer.effectAllowed = 'move'
  e.dataTransfer.setData('text/html', this.outerHTML)
}

function dragEnter(e) {
  this.classList.add('over')
}

function dragLeave(e) {
  e.stopPropagation()
  this.classList.remove('over')
}

function dragOver(e) {
  e.preventDefault()
  e.dataTransfer.dropEffect = 'move'
  return false
}

function dragDrop(e) {
  if (dragSrcEl !== this) {
    let parent = this.parentNode
    let data = new DOMParser().parseFromString(e.dataTransfer.getData('text/html'), 'text/html')
    this.classList.remove('over')
    dragSrcEl.innerHTML = this.innerHTML
    // console.log(data.activeElement.children[0], parent.childNodes)
    parent.replaceChild(data.activeElement.children[0], parent.childNodes[3])
  }
  return false
}

function dragEnd(e) {
  this.classList.remove('over')
}

function dragDropify(elem) {
  elem.addEventListener('dragstart', dragStart, true)
  elem.addEventListener('dragenter', dragEnter, true)
  elem.addEventListener('dragover', dragOver, true)
  elem.addEventListener('dragleave', dragLeave, true)
  elem.addEventListener('drop', dragDrop, true)
  elem.addEventListener('dragend', dragEnd, true)

  return false
}

//open youtube-embed
function openYTE() {
  _body.classList.add('module-open')
  fadeIn(ytModule, 0.2)
}

//close youtube-embed
function closeYTE() {
  _body.classList.remove('module-open')
  fadeOut(ytModule, 0.2)
  document.onkeydown = function (e) {
    if (e.keyCode === 37 || e.keyCode === 39) {
      return true
    }
  }
}

if (document.getElementById('close-yt')) {
  document.getElementById('close-yt').addEventListener('click', function (e) {
    e.preventDefault()
    closeYTE()
  }, false)
}

//CLOSE MODULE
function closeModule() {
  _body.classList.remove('module-open')
  if (document.getElementsByClassName('media-library').length === 0) {
    imageDetails.style.visibility = 'hidden'
    imageDetails.style.opacity = '0'
  }
  if (chooseImage) {
    chooseImage.style.display = 'block'
  }
  fadeOut(_module, 0.2)
  document.onkeydown = function (e) {
    if (e.keyCode === 37 || e.keyCode === 39) {
      return true
    }
  }
}


//OPEN MODULE
function openModule(e) {
  e.preventDefault()
  spinnerImage.style.display = 'block'
  spinnerImage.style.opacity = '1'
  selectedMedia.firstChild.style.opacity = '0'
  selectedMedia.firstChild.onload = function () {
    selectedMedia.firstChild.style.opacity = '1'
    spinnerImage.style.display = 'none'
    spinnerImage.style.opacity = '0'
  }
  //HACK SHAME
  if (selectedMedia.firstChild.tagName === 'VIDEO') {
    selectedMedia.firstChild.style.opacity = '1'
    spinnerImage.style.display = 'none'
    spinnerImage.style.opacity = '0'
  }
  setTimeout(function () {
    if (selectedMedia.firstChild.tagName === 'VIDEO') {
      selectedMedia.firstChild.style.opacity = '1'
      spinnerImage.style.display = 'none'
      spinnerImage.style.opacity = '0'
    } else {
      const rgb = getAverageRGB(selectedMedia.firstChild)
      if (rgb.r + rgb.g + rgb.b < 160) {
        document.getElementById('selected-media-container').classList.replace('black-background', 'white-background')
        document.querySelectorAll('.icon-jpress').forEach(function (icon) {
          icon.classList.replace('black-background', 'white-background')
        })
      } else {
        document.getElementById('selected-media-container').classList.replace('white-background', 'black-background')
        document.querySelectorAll('.icon-jpress').forEach(function (icon) {
          icon.classList.replace('white-background', 'black-background')
        })
      }
    }
  }, 100)
  //END OF SHAME
  if (_body.classList.contains('module-open')) {
    _module.style.display = 'block'
    selectedMedia.firstChild.style.opacity = '0'
  } else {
    _body.classList.add('module-open')
    fadeIn(_module, 0.2)
  }
}

if (moduleLinks.length > 0) {
  moduleLinksArray = Array.prototype.slice.call(moduleLinks)
  moduleLinksArray.forEach(function (moduleLink) {
    moduleLink.addEventListener('click', openModule, false)
  })
}

if (moduleClose) {
  moduleClose.addEventListener('click', closeModule, false)
  moduleClose.addEventListener('click', function () {
    _body.classList.remove('tinymce-image-module')
    _body.classList.remove('parallax-background-select')
    document.onclick = null
  }, false)
  window.onkeydown = function (e) {
    if (document.getElementsByClassName('module-open').length > 0 && _module.classList.contains('fullscreen') !== true && e.keyCode === 27) {
      closeModule()
      document.onclick = null
    }
    if (_module.classList.contains('fullscreen') && e.keyCode === 27) {
      _module.classList.remove('fullscreen')
    }
  }
}

// ARRAY LINKS HANDLER
function moduleHandler(el) {
  selectedMediaThumb = 'thumbnails/' + el.dataset.name.substr(0, el.dataset.name.lastIndexOf('.')) + '-thumbnail.jpg'

  if (el.dataset.name.indexOf('.mp4') > -1) {
    const selectedVideo = document.createElement('VIDEO')
    selectedVideo.autoplay = true
    selectedVideo.playsinline = true
    selectedVideo.muted = true
    selectedVideo.controls = true
    const selectedVideoSource = document.createElement('SOURCE')
    selectedVideoSource.src = el.href
    selectedVideoSource.type = 'video/mp4'
    selectedVideo.appendChild(selectedVideoSource)
    selectedMedia.firstChild.replaceWith(selectedVideo)
    deleteInput.value = el.dataset.name + ',' + selectedMediaThumb
  } else {
    if (selectedMedia.firstChild.tagName === 'VIDEO') {
      const selectedImage = document.createElement('IMG')
      selectedMedia.firstChild.replaceWith(selectedImage)
    }
    if (el.dataset.name.indexOf('.pdf') > -1) {
      selectedMedia.firstChild.src = el.href.replace('.pdf', '.jpg')
      deleteInput.value = el.dataset.name + ',' + selectedMediaThumb + ',' + el.dataset.name.replace('.pdf', '.jpg')
    } else {
      selectedMedia.firstChild.src = el.href
      if (_body.classList.contains('webp-server-support')) {
        if (el.href.indexOf('.jpg') > -1) {
          deleteInput.value = el.dataset.name + ',' + el.dataset.name.replace('.jpg', '.webp') + ',' + selectedMediaThumb + ',' + selectedMediaThumb.replace('.jpg', '.webp')
        } else if (el.href.indexOf('.png') > -1) {
          deleteInput.value = el.dataset.name + ',' + el.dataset.name.replace('.png', '.webp')
        } else {
          deleteInput.value = el.dataset.name
        }
      } else {
        if (el.href.indexOf('.jpg') > -1) {
          deleteInput.value = el.dataset.name + ',' + selectedMediaThumb
        } else {
          deleteInput.value = el.dataset.name
        }
      }
    }
  }
  copyUrl.value = el.href
  imageAlt.value = el.dataset.alt
  fileNameText.innerHTML = fileNameInput.value = truncateString(el.dataset.name, 10)
  if ((el.dataset.size / 1024) < 1000) {
    fileSizeText.innerHTML = (el.dataset.size / 1024).toFixed(0) + ' kB'
  } else {
    fileSizeText.innerHTML = (el.dataset.size / 1000024).toFixed(1) + ' MB'
  }
  photoCredit.value = el.dataset.credit
  captionInput.value = el.dataset.caption
  selectedMedia.firstChild.draggable = false

  _index = moduleLinksArray.indexOf(el)
  if (_index < moduleLinksArray.length - 1) {
    nextItem = moduleLinksArray[_index + 1]
  } else {
    nextItem = moduleLinksArray[0]
  }
  if (_index >= 1) {
    previousItem = moduleLinksArray[_index - 1]
  } else {
    previousItem = moduleLinksArray[moduleLinksArray.length - 1]
  }

  selectedMedia.parentNode.onclick = function (e) {
    let conW = this.innerWidth || this.clientWidth
    let rect = e.target.getBoundingClientRect()
    let x = e.clientX - rect.left
    if (e.target.id === 'fullscreen-button') {
      if (_module.classList.contains('fullscreen') !== true) {
        if (_module.requestFullscreen) {
          _module.requestFullscreen()
        } else if (_module.mozRequestFullScreen) {
          _module.mozRequestFullScreen()
        } else if (_module.webkitRequestFullscreen) {
          _module.webkitRequestFullscreen()
        } else if (_module.msRequestFullscreen) {
          _module.msRequestFullscreen()
        }
      } else {
        if ((window.fullScreen) || (window.innerWidth == screen.width && window.innerHeight == screen.height)) {
          if (document.exitFullscreen) {
            document.exitFullscreen()
          } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen()
          } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen()
          } else if (document.msExitFullscreen) {
            document.msExitFullscreen()
          }
        }
      }
      _module.classList.toggle('fullscreen')
    } else {
      if (x < (conW / 2)) {
        previousItem.click()
      } else {
        nextItem.click()
      }
    }
  }

  document.onkeydown = function (e) {
    if (e.target.nodeName.toLowerCase() !== ('input') && e.target.nodeName.toLowerCase() !== ('textarea')) {
      switch (e.keyCode) {
        case 39:
          nextItem.click()
          break
        case 37:
          e.preventDefault()
          previousItem.click()
      }
    }
  }

  document.onclick = function () {
    if (_module.querySelector('.module-inner').contains(event.target) === false && el.contains(event.target) === false) {
      moduleClose.click()
    }
  }

  //DELETE IMAGE
  let deleteForm = document.getElementById('delete-file')
  deleteForm.onsubmit = function (e) {
    e.preventDefault()
    let result = confirm(yourAboutToDeleteThisFilePermanently)
    if (result) {
      let fileName = deleteInput.value
      let requestString = 'filename=' + fileName
      dbQuery(requestString, '/jp-includes/delete/delete-file.php', 'application/x-www-form-urlencoded', messageDeleted, deleted_str)
      _body.classList.remove('module-open')
      _module.style.display = 'none'
      if (el.parentElement.parentElement.parentElement) {
        el.parentElement.parentElement.parentElement.removeChild(el.parentElement.parentElement)
      }
      for (let i = 0 i < moduleLinksArray.length i++) {
        if (moduleLinksArray[i] === el) {
          moduleLinksArray.splice(i, 1)
        }
      }
    }
  }
}

function insertImage() {
  if (_body.classList.contains('parallax-background-select')) {
    _body.classList.remove('parallax-background-select')
    _body.classList.remove('tinymce-image-module')
    return
  }
  let newImage
  let photoCreditOutput
  let captionOutput
  let fileName = selectedMedia.querySelector('img').src.replace(window.location.origin, '')
  let ext = fileName.substr(fileName.lastIndexOf('.') + 1)
  if (photoCredit.value.length > 0) {
    photoCreditOutput = '<small>FOTO: ' + photoCredit.value + '</small>'
  } else {
    photoCreditOutput = ''
  }
  if (captionInput.value.length > 0) {
    captionOutput = captionInput.value + '<br>'
  } else {
    captionOutput = ''
  }
  if (captionSwitch.checked) {
    newImage = '<figure class="image"><img class="fade-in" alt="' + imageAlt.value + '" src="' + fileName + '" width="' + selectedMedia.querySelector('img').naturalWidth + '" height="' + selectedMedia.querySelector('img').naturalHeight + '" /><figcaption>' + captionOutput + photoCreditOutput + '</figcaption></figure>'
  } else {
    newImage = '<img class="fade-in" alt="' + imageAlt.value + '" src="' + fileName + '" width="' + selectedMedia.querySelector('img').naturalWidth + '" height="' + selectedMedia.querySelector('img').naturalHeight + '" />'
  }
  tinymce.activeEditor.insertContent(newImage)
  _body.classList.remove('tinymce-image-module')
}

if (captionSwitch) {
  captionSwitch.addEventListener('change', function () {
    captionInput.classList.toggle('hidden')
  }, false)
}

//DELETE USER
const delUser = document.getElementById('delete-user')
if (delUser) {
  const delUserBtn = Array.prototype.slice.call(delUser.getElementsByTagName('button'))
  delUser.addEventListener('submit', function (e) {
    e.preventDefault()
  }, false)
  delUserBtn.forEach(function (el) {
    el.onclick = function () {
      let result = confirm(yourAboutToDeleteThisUserPermanently)
      if (result) {
        let fileName = el.name
        let requestString = 'user-to-delete=' + fileName
        dbQuery(requestString, '/jp-includes/delete/delete-user.php', 'application/x-www-form-urlencoded', messageDeleted, deleted_str)
        el.parentElement.parentElement.parentElement.removeChild(el.parentElement.parentElement)
      }
    }
  })
}

//DRAG IMAGE TINYMCE
if (document.getElementsByClassName('textarea').length > 0 && document.getElementsByClassName('logged-in').length > 0) {
  const textareas = document.querySelectorAll('.textarea')
  textareas.forEach(function (txt) {
    let txtFigures = txt.querySelectorAll('figure')
    if (txtFigures.length > 0) {
      txtFigures.forEach(function (figure) {
        let image = figure.querySelector('img')
      })
    }
  })
}

function saveAlt(el) {
  newAlt = imageAlt.value
  newCredit = photoCredit.value
  newCaption = customEncode(captionInput.value)
  let imageId = el.dataset.id
  let requestString = 'save-image-details&image-alt=' + newAlt + '&photo-credit=' + newCredit + '&image-caption=' + newCaption + '&image-id=' + imageId
  el.dataset.alt = newAlt
  el.dataset.credit = newCredit
  el.dataset.caption = newCaption
  // console.log(requestString)
  dbQuery(requestString, '/jp-includes/update/update-alt.php', 'application/x-www-form-urlencoded', messageSuccess, saved_str)
  _body.classList.remove('module-open')
  _module.style.display = 'none'
}

//OPEN/CLOSE ADMINPANEL
adminPanelButton.addEventListener('click', function (e) {
  e.preventDefault()
  adminPanelButton.classList.toggle('permanently-unhide')
  adminPanel.classList.toggle('permanently-unhide')
}, false)

document.addEventListener('click', function (e) {
  if (adminPanel.contains(e.target) !== true && adminPanelButton.contains(e.target) !== true) {
    adminPanelButton.classList.remove('permanently-unhide')
    adminPanel.classList.remove('permanently-unhide')
  }
}, passiveSupported ? {
  passive: true,
  capture: true
} : true)

document.addEventListener('mousemove', function (e) {
  if (_body.classList.contains('module-open') !== true) {
    if (e.clientX < 15) {
      adminPanel.focus()
      adminPanelButton.classList.remove('hide')
      adminPanel.classList.remove('hide')
      if (typeof tinymce !== 'undefined') {
        tinymce.EditorManager.activeEditor.getElement().blur()
      }
    } else if (e.clientX > 240) {
      adminPanel.blur()
      adminPanelButton.classList.add('hide')
      adminPanel.classList.add('hide')
    }
  }
}, passiveSupported ? {
  passive: true,
  capture: true
} : true)

//SHOW LOGOUT
const logoutImage = document.getElementsByClassName('logged-in-message-text')[0]
const logoutMenu = document.getElementsByClassName('user-menu')[0]
if (!mobile) {
  logoutImage.addEventListener('mouseover', function () {
    setTimeout(function () {
      logoutMenu.classList.add('show')
    }, 200)
  }, passiveSupported ? {
    passive: true,
    capture: true
  } : true)
} else {
  logoutImage.querySelector('a').addEventListener('click', function (e) {
    e.preventDefault()
    logoutMenu.classList.add('show')
  }, false)
}

document.addEventListener('click', function (e) {
  let isClickInside = logoutMenu.contains(e.target) || logoutImage.contains(e.target)
  if (!isClickInside) {
    logoutMenu.style.opacity = '0'
    setTimeout(function () {
      logoutMenu.classList.remove('show')
      logoutMenu.removeAttribute('style')
    }, 200)
  }
}, passiveSupported ? {
  passive: true
} : false)

//EXPAND/CLOSE ARTICLES LIST
const articlesToggle = document.getElementById('admin-articles-toggle')
if (articlesToggle) {
  articlesToggle.addEventListener('click', function (e) {
    e.preventDefault()
    articlesToggle.parentElement.classList.toggle('current-menu-item')
    articlesToggle.classList.toggle('rotate')
    document.getElementById('admin-articles-list').classList.toggle('show')
  }, false)
}

//DELETE ARTICLE
const pageDeleteForm = document.getElementById('delete-article-form')
let pageDelButtons
if (pageDeleteForm) {
  pageDelButtons = pageDeleteForm.getElementsByTagName('button')
  pageDeleteForm.addEventListener('submit', function (e) {
    e.preventDefault()
  }, false)
  Array.prototype.slice.call(pageDelButtons).forEach(function (o) {
    o.addEventListener('click', function (e) {
      e.preventDefault()
      let result = confirm(yourAboutToDeleteThisArticlePermanently)
      if (result) {
        let requestString = 'article-to-delete=' + o.name
        dbQuery(requestString, '/jp-includes/delete/delete-article.php', 'application/x-www-form-urlencoded', messageDeleted, deleted_str)
        if (window.location.href === hostName + '/' + o.name + '/') {
          window.location.href = hostName
        }
      }
    }, false)
  })
}

//SAVE CHANGES KEYBOARD SHORTCUT
document.addEventListener("keydown", function (e) {
  if ((window.navigator.platform.match("MacIntel") ? e.metaKey : e.ctrlKey) && e.keyCode == 83) {
    e.preventDefault()
    if (document.activeElement.classList.contains('textarea') && document.activeElement.closest('form').querySelector('.jp-save-changes')) {
      document.activeElement.closest('form').querySelector('.jp-save-changes').click()
    } else if (document.getElementsByClassName('jp-open').length > 0) {
      document.getElementsByClassName('jp-open')[0].closest('form').querySelector('.jp-save-changes').click()
    } else {
      document.querySelectorAll('.jp-save-changes').forEach(function (save) {
        save.click()
      })
    }
  }
}, false)

//COPY URL
if (copyUrl) {
  copyUrl.addEventListener('click', function () {
    this.select()
    document.execCommand('copy')
    copyTooltip.innerHTML = copied_str + '!'
    setTimeout(function () {
      copyTooltip.innerHTML = copyLink_str + ':'
    }, 4000)
  }, false)
}

// ENCODE SINGLE QUOTES + URICOMPONENT
function customEncode(str) {
  return encodeURIComponent(str).replace(/'/g, '%27')
}

//CHECK USER LAST_ACTIVITY
function activityWatcher() {
  let secondsSinceLastActivity = 0
  const maxInactivity = 1800
  setInterval(function () {
    secondsSinceLastActivity++
    if (secondsSinceLastActivity > maxInactivity) {
      loginModule.style.display = 'block'
    }
  }, 1000)
  function activity() {
    secondsSinceLastActivity = 0
  }
  let activityEvents = [
    'mousedown', 'keydown', 'touchstart'
  ]
  activityEvents.forEach(function (eventName) {
    document.addEventListener(eventName, activity, passiveSupported ? {
      passive: true,
      capture: true
    } : true)
  })
}

activityWatcher()

//SLUGIFY
function slugify(str) {
  str = str.replace(/^\s+|\s+$/g, '') // trim
  str = str.toLowerCase()
  // remove accents, swap ñ for n, etc
  let from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:"
  let to = "aaaaeeeeiiiioooouuuunc------"
  for (var i = 0, l = from.length i < l i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i))
  }
  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-') // collapse dashes
  return str
}

//GET BASENAME
function baseName(str) {
  let base = String(str).substring(str.lastIndexOf('/') + 1)
  if (base.lastIndexOf('.') != -1) {
    base = base.substring(0, base.lastIndexOf('.'))
  }
  return base
}

//GET EXTENSION
function fileExtension(str) {
  let base = String(str).substring(str.lastIndexOf('.') + 1)
  return base
}

//SIDEPANEL
function sidePanel(el, obj) {
  el.preventDefault()
  if (imageDetails && imgSaveBtn) {
    imageDetails.style.visibility = imgSaveBtn.style.visibility = 'visible'
    imageDetails.style.opacity = imgSaveBtn.style.opacity = '1'
  }
  if (chooseImage) {
    chooseImage.style.display = 'none'
  }
  selectedMedia.firstChild.dataset.id = obj.dataset.id
  if (selectedMedia.querySelector('img')) {
    copyUrl.value = selectedMedia.querySelector('img').src = obj.href
  } else {
    copyUrl.value = selectedMedia.querySelector('source').src = obj.href
  }
  fileNameText.innerHTML = truncateString(obj.dataset.name, 10)
  fileSizeText.innerHTML = (obj.dataset.size / 1024).toFixed(0) + ' kB'
  imageAlt.value = obj.dataset.alt
  photoCredit.value = obj.dataset.credit
  captionInput.value = obj.dataset.caption
}

//CHOOSE FEATURED IMAGE
if (mediaLibrary) {
  const featuredLinks = mediaLibrary.getElementsByTagName('a')
  Array.prototype.slice.call(featuredLinks).forEach(function (e) {
    e.addEventListener('click', function (i) {
      sidePanel(i, e)
    }, false)
  })

  //OK-button
  if (!document.getElementsByClassName('media-library').length && imgSaveBtn) {
    imgSaveBtn.addEventListener('click', function () {
      if (featuredImageElement && _body.classList.contains('tinymce-image-module') !== true) {
        featuredImageInput.value = featuredImageElement.src = selectedMedia.querySelector('img').src
      } else if (this.dataset.target !== undefined) {
        let thisSection = document.querySelector('.' + this.dataset.target)
        thisSection.style.backgroundImage = 'url(' + selectedMedia.querySelector('img').src + ')'
        thisSection.querySelector('.background-image').value = selectedMedia.querySelector('img').src
        thisSection.querySelector('.content').style.transform = 'translateY(0)'
        // _body.classList.remove('parallax-background-select')
      }
      closeModule()
    }, false)
  }
}

function switchReveal(w, s, w2, s2) {
  s.addEventListener('change', function () {
    w.classList.toggle('active')
    if (s2 && w2) {
      if (s2.checked) {
        s2.checked = false
        w2.classList.toggle('active')
      }
    }
  }, false)
}

//Hex to rgb
function hex2RGB(hex) {
  const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex)
  return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
  } : null
}

//multiply rgb
function multiRGB(hex) {
  const toRGB = hex2RGB(hex)
  return toRGB.r + toRGB.g + toRGB.b
}

//tagify tags csp
function tagify(el) {
  el.innerText.split(' ').forEach(function (tag, i) {
    const closeTag = document.createElement('sup')
    closeTag.classList.add('close-tag')
    closeTag.onclick = function () {
      closeTag.parentNode.parentNode.removeChild(closeTag.parentNode)
    }
    if (i === 0) {
      el.innerText = ''
    }
    const tagSpan = document.createElement('span')
    tagSpan.setAttribute('class', 'tag contrast-background')
    tagSpan.contentEditable = false
    tagSpan.innerText = tag + ' '
    tagSpan.appendChild(closeTag)
    el.appendChild(tagSpan)
    el.innerHTML += ' '
  }, false)
}

//SEO PAGE
if (isSettings()) {
  const mlSwitch = document.getElementById('ml-switch')
  const gfWrapper = document.getElementById('google-fonts-wrapper')
  const gfSwitchElement = document.getElementById('gf-switch')
  const tkWrapper = document.getElementById('typekit-wrapper')
  const tkSwitchElement = document.getElementById('tk-switch')
  const reCAPTCHASwitchElement = document.getElementById('recaptcha-switch')
  const gCalSwitchElement = document.getElementById('gcal-switch')
  const sendgridSwitchElement = document.getElementById('sendgrid-switch')
  const tabMenu = document.getElementById('settings-main-menu')
  const tabMenuLinks = tabMenu.querySelectorAll('a')

  const uploadFavicon = document.getElementById('upload-favicon')
  const faviconImage = document.getElementById('favicon-image')
  if (uploadFavicon) {
    faviconImage.addEventListener('click', function () {
      uploadFavicon.click()
    }, false)
    uploadFavicon.onchange = function () {
      // console.log(uploadFavicon.files[0])
      spinnerGlobal.style.display = 'block'
      spinnerGlobal.style.opacity = '1'
      Array.prototype.slice.call(this.files).forEach(function (file) {
        formData.append('file[]', file)
      })
      request.open('POST', '/jp-includes/insert/upload-favicon.php', true)
      request.onreadystatechange = function () {
        spinnerGlobal.style.display = 'none'
        spinnerGlobal.style.opacity = '0'
        message.innerText = ''
        messageSuccess.style.display = messageFailure.style.display = 'none'
        fadeIn(moduleMessage, 2)
        if (this.readyState === 4) {
          if (this.status >= 200 && this.status < 300) {
            message.innerText = theUploadSucceeded
            messageSuccess.style.display = 'block'
            faviconImage.src = document.getElementById('favicon-preview-image').src = '/assets/img/site/favicon.png?' + new Date().getTime()
          } else {
            messageFailure.style.display = 'block'
            if (this.status === 413) {
              message.innerHTML = fileTooBig
              messageFailure.style.display = 'block'
            } else if (this.status === 415) {
              message.innerHTML = thisFileTypeIsNotAllowed
              messageFailure.style.display = 'block'
            } else {
              message.innerHTML = thereWasAnError
              console.log(this.responseText)
            }
          }
          setTimeout(function () {
            fadeOut(moduleMessage, 2)
          }, 1000)
          setTimeout(function () {
            message.innerText = ''
            messageSuccess.style.display = messageFailure.style.display = 'none'
          }, 6000)
        }
      }
      request.send(formData)
      Array.prototype.slice.call(this.files).forEach(function (file) {
        formData.delete('file[]', file)
      })
      return
    }
  }

  const formGroups = Array.prototype.slice.call(document.getElementsByClassName('form-group-expandable'))
  document.addEventListener('click', function () {
    if (!event.target.classList.contains('form-group-expandable') && !_body.classList.contains('module-open')) {
      formGroups.forEach(function (o) {
        o.classList.remove('wide')
      })
    }
  }, passiveSupported ? {
    passive: true,
    capture: true
  } : true)
  document.onkeydown = function (e) {
    if (e.key === 'Escape' || e.key === 'Esc') {
      formGroups.forEach(function (o) {
        o.classList.remove('wide')
      })
    }
  }
  formGroups.forEach(function (el) {
    el.addEventListener('click', function () {
      formGroups.forEach(function (o) {
        o.classList.remove('wide')
      })
      this.classList.add('wide')
    }, passiveSupported ? {
      passive: true,
      capture: true
    } : true)
  })

  //TAB MENU
  tabMenuLinks.forEach(function (a) {
    const target = a.href.split('#').slice(-1)[0]
    if (window.location.hash) {
      if (target === window.location.hash.substring(1)) {
        setTimeout(function () {
          a.click()
        }, 100)
      }
    }
    const nxtLi = a.parentElement.nextElementSibling
    const prvLi = a.parentElement.previousElementSibling
    a.addEventListener('click', function (e) {
      e.preventDefault()
      window.history.replaceState(null, null, '#' + target)
      if (target === 'updates-wrapper') {
        document.querySelector('input[type="submit"]').style.display = 'none'
      } else {
        document.querySelector('input[type="submit"]').style.display = null
      }
      if (nxtLi && nxtLi.classList.contains('current')) {
        nxtLi.getElementsByTagName('a')[0].classList.remove('previous')
        nxtLi.getElementsByTagName('a')[0].classList.add('next')
      }
      if (prvLi && prvLi.classList.contains('current')) {
        prvLi.getElementsByTagName('a')[0].classList.remove('next')
        prvLi.getElementsByTagName('a')[0].classList.add('previous')
      }
      Array.prototype.slice.call(tabMenu.getElementsByTagName('li')).forEach(function (t) {
        t.classList.remove('current')
      })
      a.parentElement.classList.toggle('current')
      document.querySelectorAll('.form-wrapper').forEach(function (el) {
        el.style.display = 'none'
      })
      document.getElementById(target).style.display = 'block'
    }, false)
  })

  //MULTILINGUAL
  switchReveal(document.getElementById('ml-wrapper'), mlSwitch)

  //GOOGLE FONTS
  switchReveal(gfWrapper, gfSwitchElement, tkWrapper, tkSwitchElement)

  //TYPEKIT
  switchReveal(tkWrapper, tkSwitchElement, gfWrapper, gfSwitchElement)

  //reCAPTCHA
  switchReveal(document.getElementById('recaptcha-wrapper'), reCAPTCHASwitchElement)

  //Google Calendar
  switchReveal(document.getElementById('gcal-wrapper'), gCalSwitchElement)

  //Sendgrid
  switchReveal(document.getElementById('sendgrid-api-key'), sendgridSwitchElement)

  //Facebook
  switchReveal(document.getElementById('fb-page'), document.getElementById('fb-page-switch'))
  //Twitter
  switchReveal(document.getElementById('twitter-page'), document.getElementById('twitter-page-switch'))
  //Instagram
  switchReveal(document.getElementById('ig-page'), document.getElementById('ig-page-switch'))
  //YouTube
  switchReveal(document.getElementById('yt-page'), document.getElementById('yt-page-switch'))
  //Spotify
  switchReveal(document.getElementById('spotify-profile'), document.getElementById('spotify-switch'))
  //LinkedIn
  switchReveal(document.getElementById('li-page'), document.getElementById('li-page-switch'))
  //TripAdvisor
  switchReveal(document.getElementById('ta-page'), document.getElementById('ta-switch'))

  //LOGO
  const logoPreview = document.getElementById('logo-preview')
  // const logoInput = document.getElementById('logo-input').querySelector('.logo-container')
  // const inputField = document.getElementById('logo-input').querySelector('.code-input-field')
  logoPreview.innerHTML = codeEditorLogo.getValue()
  // logoInput.addEventListener('click', function () {
  //   inputField.classList.toggle('hidden')
  // }, false)
  document.getElementById('logo-input').querySelector('.code-input-field').addEventListener('keyup', function () {
    logoPreview.innerHTML = codeEditorLogo.getValue()
  }, false)

  //NAVIGATION
  let menuHandlers
  let menuHandlersArray
  const editMenu = document.getElementById('header-menu-edit')
  if (editMenu) {
    menuHandlersArray = Array.prototype.slice.call(editMenu.getElementsByClassName('menu-item-handle'))
    menuHandlersArray.forEach(function (item) {
      dragDropify(item)
    })
  }

  //CSP-HANLDER
  const cspDummy = document.getElementById('csp-dummy')
  const _placeholder = '*.example-1.com *.example-2.com'
  if (cspDummy.innerText === '') {
    cspDummy.innerText = _placeholder
  } else {
    tagify(cspDummy)
  }

  cspDummy.addEventListener('keyup', function (e) {
    if (e.keyCode == 32) {
      document.getElementById('csp').value = cspDummy.innerText
      setTimeout(function () {
        tagify(cspDummy)
      }, 600)
    }
  }, false)

  //Plugins
  if (document.getElementById('sendgrid-update')) {
    document.getElementById('sendgrid-update').addEventListener('click', function () {
      const requestString = 'update-sendgrid&cmd=' + btoa('update')
      dbQuery(requestString, '/jp-includes/plugins/sendgrid/webComposer.php', 'application/x-www-form-urlencoded', messageSuccess, 'Great success!')
    }, false)
  }

  //SAVE CHANGES
  const siteInfo = document.getElementById('siteinfo')
  siteInfo.addEventListener('submit', function (e) {
    e.preventDefault()
    let siteName = document.getElementById('sitename').value
    let legalName = document.getElementById('legal-name').value
    let siteDesc = document.getElementById('site-desc').value
    let logo = encodeURIComponent(codeEditorLogo.getValue())
    let featuredImageSite = featuredImageInput.value
    let themeColor = document.getElementById('theme-color').value
    let secondaryColor = document.getElementById('secondary-color').value
    let whiteColor = document.getElementById('white-color').value
    let contrastColor = document.getElementById('theme-color-contrast').value

    //Calibrate fontColor
    let whiteBackgroundHeadline,
      whiteBackgroundBody,
      whiteBackgroundLink,
      themeBackgroundHeadline,
      themeBackgroundBody,
      themeBackgroundLink,
      secondaryBackgroundHeadline,
      secondaryBackgroundBody,
      secondaryBackgroundLink

    if (multiRGB(themeColor) < 290) {
      themeBackgroundHeadline = themeBackgroundBody = themeBackgroundLink = whiteColor
      whiteBackgroundHeadline = whiteBackgroundBody = whiteBackgroundLink = themeColor
      if (multiRGB(themeColor) > 210) {
        whiteBackgroundBody = '333'
        if (multiRGB(secondaryColor) < 210) {
          whiteBackgroundBody = secondaryColor
        }
      }
      if (multiRGB(secondaryColor) > 310) {
        themeBackgroundHeadline = secondaryColor
        if (multiRGB(secondaryColor) < 370) {
          whiteBackgroundHeadline = secondaryColor
        }
      }
      if (multiRGB(contrastColor) > 350) {
        themeBackgroundLink = contrastColor
      }
    } else {
      if (multiRGB(secondaryColor) < 320) {
        themeBackgroundHeadline = themeBackgroundBody = themeBackgroundLink = whiteBackgroundHeadline = whiteBackgroundBody = whiteBackgroundLink = secondaryColor
        if (multiRGB(secondaryColor) < multiRGB(themeColor) && multiRGB(themeColor) < 450) {
          whiteBackgroundHeadline = themeColor
        }
      } else {
        if (multiRGB(secondaryColor) > 370) {
          themeBackgroundHeadline = whiteBackgroundHeadline = secondaryColor
        } else {
          themeBackgroundHeadline = themeBackgroundLink = whiteBackgroundHeadline = whiteBackgroundLink = '333'
        }
        themeBackgroundBody = whiteBackgroundBody = '333'
      }
    }

    if (multiRGB(contrastColor) < 450) {
      whiteBackgroundLink = contrastColor
      if (multiRGB(themeColor) > 350) {
        themeBackgroundLink = contrastColor
      }
    }

    if (multiRGB(secondaryColor) < 290) {
      secondaryBackgroundHeadline = secondaryBackgroundBody = secondaryBackgroundLink = whiteColor
      if (multiRGB(themeColor) > 310) {
        secondaryBackgroundHeadline = themeColor
      }
      if (multiRGB(contrastColor) > 350) {
        secondaryBackgroundLink = contrastColor
      }
    } else {
      if (multiRGB(themeColor) < 320) {
        secondaryBackgroundHeadline = secondaryBackgroundBody = secondaryBackgroundLink = themeColor
      } else {
        secondaryBackgroundHeadline = secondaryBackgroundBody = secondaryBackgroundLink = '333'
      }
    }

    const fontColorObject = {
      whiteBackground: {
        headline: whiteBackgroundHeadline,
        body: whiteBackgroundBody,
        link: whiteBackgroundLink
      },
      themeBackground: {
        headline: themeBackgroundHeadline,
        body: themeBackgroundBody,
        link: themeBackgroundLink
      },
      secondaryBackground: {
        headline: secondaryBackgroundHeadline,
        body: secondaryBackgroundBody,
        link: secondaryBackgroundLink
      }
    }
    const fontColor = JSON.stringify(fontColorObject)

    const tags = document.getElementById('tags').value
    const mainEmail = document.getElementById('main-email').value
    let mailHeaderSwitch = ''
    if (document.getElementById('mail-header-switch').checked) {
      mailHeaderSwitch = 'checked'
    }
    let phoneHeaderSwitch = ''
    if (document.getElementById('phone-header-switch').checked) {
      phoneHeaderSwitch = 'checked'
    }
    const telephone = encodeURIComponent(document.getElementById('telephone').value)
    const cfReceiptBody = encodeURIComponent(tinymce.get('cf-receipt-body').getContent())
    let cfReceiptBodyAltLang
    if (document.getElementById('cf-receipt-body-alt-lang')) {
      cfReceiptBodyAltLang = encodeURIComponent(tinymce.get('cf-receipt-body-alt-lang').getContent())
    }
    let trackingHeadSwitch = ''
    if (document.getElementById('tracking-head-switch').checked) {
      trackingHeadSwitch = 'checked'
    }
    const trackingHead = encodeURIComponent(codeEditorHead.getValue())
    let trackingBodySwitch = ''
    if (document.getElementById('tracking-body-switch').checked) {
      trackingBodySwitch = 'checked'
    }
    const trackingBody = encodeURIComponent(codeEditorBody.getValue())
    let codeFooterSwitch = ''
    if (document.getElementById('code-footer-switch').checked) {
      codeFooterSwitch = 'checked'
    }
    const codeFooter = encodeURIComponent(codeEditorFooter.getValue())
    let customShortcodeSwitch = ''
    if (document.getElementById('custom-shortcode-switch').checked) {
      customShortcodeSwitch = 'checked'
    }
    const customShortcode = encodeURIComponent(codeEditorShortcode.getValue())
    let customCursor = ''
    if (document.getElementById('custom-cursor').checked) {
      customCursor = 'checked'
    }
    let toTheTopSwitch = ''
    if (document.getElementById('to-the-top-switch').checked) {
      toTheTopSwitch = 'checked'
    }
    let smSwitch = ''
    if (document.getElementById('sm-switch').checked) {
      smSwitch = 'checked'
    }
    let mlCheck = ''
    if (mlSwitch.checked) {
      mlCheck = 'checked'
    }
    let nonceSwitch = ''
    if (document.getElementById('nonce-switch').checked) {
      nonceSwitch = 'checked'
    }
    const csp = document.getElementById('csp').value
    const altLangOne = document.getElementById('alt-lang-1').value
    const altLangOneDesc = document.getElementById('alt-lang-1-sitedesc').value
    let someShareSwitch = ''
    if (document.getElementById('some-share-switch').checked) {
      someShareSwitch = 'checked'
    }
    const fbPageID = document.getElementById('fb-page-id').value
    const fbAppID = document.getElementById('fb-app-id').value
    const fbAppSecret = document.getElementById('fb-app-secret').value
    const fbPage = document.getElementById('fb-page').value
    let fbConnectSwitch = ''
    if (document.getElementById('fb-connect-switch').checked) {
      fbConnectSwitch = 'checked'
    }

    let fbPageSwitch = ''
    if (document.getElementById('fb-page-switch').checked) {
      fbPageSwitch = 'checked'
    }
    let twitterPage = document.getElementById('twitter-page').value
    let twitterPageSwitch = ''
    if (document.getElementById('twitter-page-switch').checked) {
      twitterPageSwitch = 'checked'
    }
    const igAccountID = document.getElementById('ig-account-id').value
    const igUserID = document.getElementById('ig-user-id').value
    const igAppID = document.getElementById('ig-app-id').value
    const igAppSecret = document.getElementById('ig-app-secret').value
    const igPage = document.getElementById('ig-page').value
    let igPageSwitch = ''
    if (document.getElementById('ig-page-switch').checked) {
      igPageSwitch = 'checked'
    }
    const ytPage = document.getElementById('yt-page').value
    let ytPageSwitch = ''
    if (document.getElementById('yt-page-switch').checked) {
      ytPageSwitch = 'checked'
    }
    const spotifyProfile = document.getElementById('spotify-profile').value
    let spotifySwitch = ''
    if (document.getElementById('spotify-switch').checked) {
      spotifySwitch = 'checked'
    }
    const liPage = document.getElementById('li-page').value
    let liPageSwitch = ''
    if (document.getElementById('li-page-switch').checked) {
      liPageSwitch = 'checked'
    }
    const taPage = document.getElementById('ta-page').value
    let taSwitch = ''
    if (document.getElementById('ta-switch').checked) {
      taSwitch = 'checked'
    }
    let gfSwitch = ''
    if (document.getElementById('gf-switch').checked) {
      gfSwitch = 'checked'
    }
    let gmSwitch = ''
    if (document.getElementById('gm-switch').checked) {
      gmSwitch = 'checked'
    }
    let gCalSwitch = ''
    if (gCalSwitchElement.checked) {
      gCalSwitch = 'checked'
    }
    let contestSwitch = ''
    if (document.getElementById('contest-switch').checked) {
      contestSwitch = 'checked'
    }
    let reCAPTCHASwitch = ''
    if (reCAPTCHASwitchElement.checked) {
      reCAPTCHASwitch = 'checked'
    }
    let sendgridSwitch = ''
    if (sendgridSwitchElement.checked) {
      sendgridSwitch = 'checked'
    }
    const gCalClientId = document.getElementById('gCal-clientId').value
    const gCalProjectId = document.getElementById('gCal-projectId').value
    const gCalClientSecret = document.getElementById('gCal-clientSecret').value
    const reCAPTCHA_siteKey = document.getElementById('reCAPTCHA-siteKey').value
    const reCAPTCHA_serverKey = document.getElementById('reCAPTCHA-serverKey').value
    const googleAPIkey = document.getElementById('google-api-key').value
    const sendgridAPIkey = document.getElementById('sendgrid-api-key').value
    let fontFace = ''
    if (fontBodyInput.value !== '' && fontBodyInput !== false) {
      if (fontHeadingInput.value === fontBodyInput.value) {
        fontFace = encodeURIComponent(document.getElementById('font-' + slugify(fontBodyInput.value)).innerHTML)
      } else {
        fontFace = encodeURIComponent((document.getElementById('font-' + slugify(fontBodyInput.value)).innerHTML) + (document.getElementById('font-' + slugify(fontHeadingInput.value)).innerHTML))
      }
    }
    let tkSwitch = ''
    const tkSwitchInput = document.getElementById('tk-switch').checked
    if (tkSwitchInput === true) {
      tkSwitch = 'checked'
    }
    const tkStylesheet = encodeURIComponent(tkStylesheetEditor.getValue())
    const tkFontFamily = customEncode(document.getElementById('tk-font-family').value)
    const tkFontFamilyHeader = customEncode(document.getElementById('tk-font-family-header').value)
    let robotsSwitch = ''
    if (document.getElementById('robots-switch').checked) {
      robotsSwitch = 'checked'
    }
    const lang = document.getElementById('jp-lang').value
    const backendLang = document.getElementById('backend-lang').value
    let nativeFont
    if (document.getElementById('native-font')) {
      nativeFont = document.getElementById('native-font').value
    }
    const requestString = 'save&sitename=' + siteName + '&legal-name=' + legalName + '&site-desc=' + siteDesc + '&tags=' + tags + '&main-email=' + mainEmail + '&telephone=' + telephone + '&mail-header-switch=' + mailHeaderSwitch + '&phone-header-switch=' + phoneHeaderSwitch + '&cf-receipt-body=' + cfReceiptBody + '&cf-receipt-body-alt-lang=' + cfReceiptBodyAltLang + '&logo=' + logo + '&featured-image-site=' + featuredImageSite + '&theme-color=' + themeColor + '&secondary-color=' + secondaryColor + '&theme-color-contrast=' + contrastColor + '&white-color=' + whiteColor + '&font-color=' + fontColor + '&font-heading=' + fontHeadingInput.value + '&font-body=' + fontBodyInput.value + '&font-face=' + fontFace + '&tk-switch=' + tkSwitch + '&tk-stylesheet=' + tkStylesheet + '&tk-font-family=' + tkFontFamily + '&tk-font-family-header=' + tkFontFamilyHeader + '&tracking-head-switch=' + trackingHeadSwitch + '&tracking-head=' + trackingHead + '&tracking-body-switch=' + trackingBodySwitch + '&tracking-body=' + trackingBody + '&code-footer-switch=' + codeFooterSwitch + '&code-footer=' + codeFooter + '&custom-shortcode-switch=' + customShortcodeSwitch + '&custom-shortcode=' + customShortcode + '&some-share-switch=' + someShareSwitch + '&fb-page-id=' + fbPageID + '&fb-app-id=' + fbAppID + '&fb-app-secret=' + fbAppSecret + '&fb-page=' + fbPage + '&fb-page-switch=' + fbPageSwitch + '&twitter-page=' + twitterPage + '&twitter-page-switch=' + twitterPageSwitch + '&ig-account-id=' + igAccountID + '&ig-user-id=' + igUserID + '&ig-app-id=' + igAppID + '&ig-app-secret=' + igAppSecret + '&ig-page=' + igPage + '&ig-page-switch=' + igPageSwitch + '&yt-page=' + ytPage + '&yt-page-switch=' + ytPageSwitch + '&spotify-profile=' + spotifyProfile + '&spotify-switch=' + spotifySwitch + '&li-page=' + liPage + '&li-page-switch=' + liPageSwitch + '&gf-switch=' + gfSwitch + '&custom-cursor=' + customCursor + '&robots-switch=' + robotsSwitch + '&lang=' + lang + '&ml-switch=' + mlCheck + '&alt-lang-1=' + altLangOne + '&alt-lang-1-sitedesc=' + altLangOneDesc + '&ta-page=' + taPage + '&ta-switch=' + taSwitch + '&sm-switch=' + smSwitch + '&recaptcha-switch=' + reCAPTCHASwitch + '&reCAPTCHA-siteKey=' + reCAPTCHA_siteKey + '&reCAPTCHA-serverKey=' + reCAPTCHA_serverKey + '&google-api-key=' + googleAPIkey + '&sendgrid-switch=' + sendgridSwitch + '&sendgrid-api-key=' + sendgridAPIkey + '&native-font=' + nativeFont + '&gm-switch=' + gmSwitch + '&contest-switch=' + contestSwitch + '&fb-connect-switch=' + fbConnectSwitch + '&to-the-top-switch=' + toTheTopSwitch + '&gcal-switch=' + gCalSwitch + '&gcal-client-id=' + gCalClientId + '&gcal-client-secret=' + gCalClientSecret + '&gcal-project-id=' + gCalProjectId + '&backend-lang=' + backendLang + '&nonce-switch=' + nonceSwitch + '&csp=' + csp

    dbQuery(requestString, '/jp-includes/update/update-siteinfo.php', 'application/x-www-form-urlencoded', messageSuccess, saved_str)
  }, false)

  //colornames
  document.getElementById('theme-color-label').innerHTML += ' <small>«' + ntc.name(themeColor) + '»</small>'
  document.getElementById('secondary-color-label').innerHTML += ' <small>«' + ntc.name(secondaryColor) + '»</small>'
  document.getElementById('theme-color-contrast-label').innerHTML += ' <small>«' + ntc.name(contrastColor) + '»</small>'
  document.getElementById('white-color-label').innerHTML += ' <small>«' + ntc.name(whiteColor) + '»</small>'
}

//MEDIA LIBRARY
if (document.getElementsByClassName('media-library').length > 0) {

  deleteInput = document.getElementById('delete-file-input')

  //UPLOAD MEDIA
  const uploadForm = document.getElementById('upload-form')
  uploadForm.addEventListener('submit', function (e) {
    e.preventDefault()
    spinnerGlobal.style.display = 'block'
    spinnerGlobal.style.opacity = '1'
    const fileArray = Array.prototype.slice.call(document.getElementById('fileToUpload').files)
    let fileSize
    let fileName
    fileArray.forEach(function (file) {
      formData.append('file[]', file)
    })
    request.open('POST', '/jp-includes/insert/upload-request.php', true)
    request.onreadystatechange = function () {
      spinnerGlobal.style.display = 'none'
      spinnerGlobal.style.opacity = '0'
      message.innerText = ''
      messageSuccess.style.display = messageFailure.style.display = 'none'
      mediaLibrary.classList.add('push-up')
      uploadForm.classList.remove('file-selected')
      label.querySelector('.upload-label').innerHTML = uploadImage_str
      fadeIn(moduleMessage, 2)
      if (this.readyState === 4) {
        if (this.status >= 200 && this.status < 300) {
          message.innerText = theUploadSucceeded
          messageSuccess.style.display = 'block'
          fileArray.forEach(function (file) {
            let li = document.createElement('li')
            let div1 = document.createElement('div')
            let a = document.createElement('a')
            let div2 = document.createElement('div')
            let img = document.createElement('img')
            let mimeIcon = document.createElement('span')
            mimeIcon.classList.add('mimetype-icon')
            div1.classList.add('preview-holder')
            div2.classList.add('centered')
            a.classList.add('module-link')
            a.setAttribute('role', 'checkbox')
            a.setAttribute('tabindex', '0')
            let fileName = file.name.replace(/\s/g, '_')
            let fileTitle = baseName(fileName)
            let fileType = fileExtension(fileName).toLowerCase()

            for (let i = 0 i < moduleLinksArray.length i++) {
              while (moduleLinksArray[i].dataset.name === fileName) {
                fileTitle = fileTitle + '_' + i
                fileName = fileTitle + '.' + fileType
                i++
              }
            }
            a.dataset.alt = ''
            a.dataset.name = fileTitle + '.' + fileType
            a.dataset.id = request.responseText
            a.dataset.size = file.size
            a.dataset.credit = ''
            a.dataset.caption = ''
            if (fileType === 'pdf' || fileType === 'jpg' || fileType === 'jpeg' || fileType === 'mp4') {
              img.src = '/uploads/thumbnails/' + fileTitle + '-thumbnail.jpg'
              if (fileType === 'pdf') {
                a.href = '/uploads/' + fileTitle + '.jpg'
              } else {
                a.href = '/uploads/' + fileTitle + '.' + fileType
                if (file.size > 350000) {
                  if (file.width > file.height && file.width > 1400) {
                    a.dataset.size = ((file.size / (file.width / 700)) * 0.8).toFixed(0)
                  } else if (file.width < file.height && file.height > 1400) {
                    a.dataset.size = ((file.size / (file.height / 700)) * 0.8).toFixed(0)
                  } else {
                    a.dataset.size = file.size * 0.8
                  }
                }
              }
            } else {
              img.src = a.href = '/uploads/' + fileTitle + '.' + fileType
            }
            if (fileType === 'mp4' || fileType === 'pdf') {
              if (fileType == 'mp4') {
                mimeIcon.classList.add('icon-film-camerajpress')
              } else {
                mimeIcon.classList.add('icon-articlejpress')
              }
              div2.appendChild(mimeIcon)
            }
            div2.appendChild(img)
            a.appendChild(div2)
            div1.appendChild(a)
            li.appendChild(div1)
            mediaLibrary.insertBefore(li, mediaLibrary.childNodes[0])
            moduleLinksArray.unshift(a)
            a.addEventListener('click', openModule, false)
            a.addEventListener('click', function () {
              moduleHandler(a)
              if (imgSaveBtn) {
                imgSaveBtn.onclick = function () {
                  saveAlt(a)
                  setTimeout(function () {
                    closeModule()
                  }, 1000)
                  return false
                }
              }
            }, false)
            a.addEventListener('click', function (i) {
              sidePanel(i, a)
            }, false)
          })
        } else if (this.status >= 500 && this.status <= 511 || this.status >= 400 && this.status < 413) {
          message.innerHTML = thereWasAnError
          messageFailure.style.display = 'block'
          console.log(this.responseText)
        } else if (this.status === 413) {
          message.innerHTML = fileTooBig
          messageFailure.style.display = 'block'
        } else if (this.status === 415) {
          message.innerHTML = thisFileTypeIsNotAllowed
          messageFailure.style.display = 'block'
        } else {
          message.innerHTML = thereWasAnError
          messageFailure.style.display = 'block'
        }
        setTimeout(function () {
          fadeOut(moduleMessage, 2)
        }, 1000)
        setTimeout(function () {
          message.innerText = ''
          messageSuccess.style.display = messageFailure.style.display = 'none'
        }, 6000)
      } else {
        return
      }
      return
    }
    request.send(formData)
    fileArray.forEach(function (file) {
      formData.delete('file[]', file)
    })
  }, false)

  //HANDLE UPLOADED IMAGE
  const inputs = document.getElementsByClassName('inputfile')
  const uploadButton = document.getElementById('upload')
  const label = document.getElementById('fileToUpload-label')
  Array.prototype.slice.call(inputs).forEach(function (input) {
    let labelVal = label.innerHTML

    input.addEventListener('change', function (e) {
      let fileName
      if (this.files && this.files.length > 1) {
        fileName = (this.dataset.multipleCaption || '').replace('{count}', this.files.length)
      } else {
        fileName = e.target.value.split('\\').pop()
      }
      //TRUNCATE FILENAME
      if (fileName) {
        if (fileName.length > 20) {
          let trFilename = fileName.substring(0, 20)
          label.querySelector('.upload-label').innerHTML = trFilename + '…'
        } else {
          label.querySelector('.upload-label').innerHTML = fileName
        }
      } else {
        label.innerHTML = labelVal
      }
      input.form.classList.add('file-selected')
      mediaLibrary.classList.remove('push-up')
    }, false)
  })

  if (moduleLinksArray) {
    moduleLinksArray.forEach(function (moduleLink) {
      moduleLink.addEventListener('click', function () {
        moduleHandler(moduleLink)
        if (imgSaveBtn) {
          imgSaveBtn.onclick = function () {
            saveAlt(moduleLink)
            setTimeout(function () {
              closeModule()
            }, 1000)
            return false
          }
        }
      }, false)
    })
  }
}

//SECITON OPTIONS
function secOpts(el1) {
  el1.classList.add('jp-open')
  let bClass
  if (el1.parentElement.classList.contains('theme-background')) {
    bClass = 'secondary-background'
  } else {
    bClass = 'theme-background'
  }
  el1.classList.add(bClass)
  el1.querySelector('.section-menu').classList.add('show')
  el1.parentNode.style.overflow = 'visible'
  el1.parentNode.style.zIndex = '3'
  // console.log(el1.parentNode)
}

//DELETE SECTION FUNCTION
function deleteSec(el, id, i) {
  let requestString
  event.preventDefault()
  let result = confirm(yourAboutToDeleteThisSectionPermanently)
  if (result) {
    requestString = 'section-to-delete=' + id
    if (el.parentElement.parentElement) {
      el.parentElement.parentElement.removeChild(el.parentElement)

    }
    dbQuery(requestString, '/jp-includes/delete/delete-section.php', 'application/x-www-form-urlencoded', messageDeleted, deleted_str)
  }
}

//TOGGLE BACKGROUND MENU
function toggleBgMenu(el) {
  event.preventDefault()
  el.classList.toggle('show')
}

//TOGGLE BACKGROUND
function toggleBg(input, el1, el2, el3, el4, el5, editDiv) {
  if (input.value.includes('translucent')) {
    input.value = el1.value + ' translucent'
  } else {
    input.value = el1.value
  }
  editDiv.parentElement.classList.add(el1.value)
  editDiv.classList.add(el2.value)
  editDiv.parentElement.classList.remove(el2.value)
  editDiv.classList.remove(el1.value)
  editDiv.parentElement.classList.remove(el3.value)
  editDiv.classList.remove(el3.value)
  editDiv.parentElement.classList.remove(el4.value)
  editDiv.classList.remove(el4.value)
  editDiv.parentElement.classList.remove(el5.value)
  if (!el1.id.includes('image-background-')) {
    editDiv.parentElement.style.backgroundImage = 'none'
  }
}

//Add section function
function addSection(button, sections, insert, newButton, buttons, obj, deleteButton, originalDiv, inputID, opts) {
  const currentOrder = button.dataset.order
  tinymce.remove()
  sections.splice(currentOrder, 0, insert)
  let referenceNode = document.querySelector('.section-' + currentOrder)
  let requestString = 'new-section&content-lang=' + siteLang + '&array-index=' + currentOrder
  newButton.dataset.order = currentOrder
  newButton.addEventListener('click', function () {
    addSection(newButton, sections, insert, newButton, buttons, obj, deleteButton, originalDiv, inputID, opts)
  }, false)
  buttons.forEach(function (a) {
    if (parseInt(a.dataset.order) >= parseInt(currentOrder)) {
      a.dataset.order = parseInt(a.dataset.order) + 1
    }
  })
  buttons.push(newButton)
  referenceNode.parentNode.insertBefore(insert, referenceNode.nextSibling)
  referenceNode.parentNode.insertBefore(newButton, insert)
  sections.forEach(function (sec, i) {
    sec.querySelector('.array-index').value = i + 1
    setTimeout(function () {
      sec.querySelector('.textarea').id = 'textarea-' + (i + 1)
    }, 100)
  })
  setTimeout(function () {
    tinymce.init(tinySettings)
  }, 200)
  dbQuery(requestString, '/jp-includes/insert/add-section.php', 'application/x-www-form-urlencoded', messageSuccess, added_str, obj).then(function () {
    deleteButton.addEventListener('click', function () {
      deleteSec(originalDiv, obj.id, currentOrder)
    }, false)
    setTimeout(function () {
      inputID.value = originalDiv.dataset.id = obj.id
    }, 100)
  })
  opts.push(insert)
}

//FRONTPAGE
if (isHome()) {

  //INSERT IMAGE
  if (imgSaveBtn) {
    imgSaveBtn?.addEventListener('click', function () {
      insertImage()
    }, false)
  }

  //SECTION SETTINGS
  const sectionOptions = Array.prototype.slice.call(document.getElementsByClassName('edit-section'))
  sectionOptions.forEach(function (secOpt, i) {
    const classInput = secOpt.parentElement.querySelector('.class')
    const editBg = document.getElementById('edit-background-' + (i + 1))
    const bgOptions = secOpt.querySelector('.edit-background-options')
    if (secOpt.id !== 'edit-footer') {
      secOpt.addEventListener('click', function () {
        secOpts(secOpt) //bgOptions
      }, false)
    }
    document.documentElement.addEventListener('click', function (o) {
      if (secOpt.contains(o.target) !== true) {
        secOpt.classList.remove('jp-open')
        secOpt.classList.remove('theme-background')
        secOpt.classList.remove('secondary-background')
        secOpt.parentNode.style.overflow = 'hidden'
        secOpt.parentNode.style.zIndex = 'auto'
        secOpt.querySelector('.section-menu').classList.remove('show')
        if (bgOptions) {
          bgOptions.classList.remove('show')
        }
      }
    }, passiveSupported ? {
      passive: true,
      capture: true
    } : true)

    //EDIT BACKGROUND
    if (editBg) {
      const themeBackground = document.getElementById('theme-background-' + (i + 1))
      const secondaryBackground = document.getElementById('secondary-background-' + (i + 1))
      const whiteBackground = document.getElementById('white-background-' + (i + 1))
      const blackBackground = document.getElementById('black-background-' + (i + 1))
      const imageBackground = document.getElementById('image-background-' + (i + 1))
      const tranSwitch = document.getElementById('translucence-switch-' + (i + 1))
      editBg.addEventListener('click', function () {
        toggleBgMenu(bgOptions)
      }, false)
      themeBackground.addEventListener('change', function () {
        toggleBg(classInput, themeBackground, secondaryBackground, whiteBackground, blackBackground, imageBackground, secOpt)
        // console.log(classInput, themeBackground.value, secondaryBackground.value, whiteBackground.value, secOpt)
      }, false)
      secondaryBackground.addEventListener('change', function () {
        toggleBg(classInput, secondaryBackground, themeBackground, whiteBackground, blackBackground, imageBackground, secOpt)
        // console.log(classInput, secondaryBackground.value, themeBackground.value, whiteBackground.value, secOpt)
      }, false)
      whiteBackground.addEventListener('change', function () {
        toggleBg(classInput, whiteBackground, themeBackground, secondaryBackground, blackBackground, imageBackground, secOpt)
        // console.log(classInput, whiteBackground.value, themeBackground.value, secondaryBackground.value, secOpt)
      }, false)
      blackBackground.addEventListener('change', function () {
        toggleBg(classInput, blackBackground, themeBackground, secondaryBackground, whiteBackground, imageBackground, secOpt)
        // console.log(classInput, whiteBackground.value, themeBackground.value, secondaryBackground.value, secOpt)
      }, false)
      imageBackground.parentElement.querySelector('label').addEventListener('click', function () {
        imageBackground.checked = true
        toggleBg(classInput, imageBackground, themeBackground, secondaryBackground, whiteBackground, blackBackground, secOpt)
        classInput.value = imageBackground.value
        if (imgSaveBtn) imgSaveBtn.dataset.target = secOpt.parentElement.classList[0]
        _body.classList.add('parallax-background-select')
      }, false)
      tranSwitch.addEventListener('change', function () {
        if (this.checked) {
          classInput.value += ' translucent'
          classInput.parentElement.classList.add('translucent')
          // console.log(classInput.value)
        } else {
          classInput.value = classInput.value.replace(' translucent', '')
          classInput.parentElement.classList.remove('translucent')
          // console.log(classInput.value)
        }
      }, false)

      //Name colors
      secOpt.querySelector('.radio-list').getElementsByTagName('li')[0].querySelector('label').innerText = ntc.name(themeColor)
      secOpt.querySelector('.radio-list').getElementsByTagName('li')[1].querySelector('label').innerText = ntc.name(secondaryColor)
      secOpt.querySelector('.radio-list').getElementsByTagName('li')[2].querySelector('label').innerText = ntc.name(whiteColor)
    }

    //DELETE SECTION
    let deleteLink = document.getElementById('delete-section-' + (i + 1))
    if (deleteLink) {
      let sectionID = secOpt.dataset.id
      deleteLink.addEventListener('click', function (e) {
        deleteSec(secOpt, sectionID, i + 1)
      }, false)
    }
  })

  //VARIABLES
  let sectionText
  let sectionID
  let contentLang
  let contentClass
  let bgImage
  let arrayIndex
  let sectionsArray = Array.prototype.slice.call(document.getElementsByTagName('section'))

  //SECTION ARRAY
  sectionsArray.forEach(function (sec, i) {
    sec.querySelector('.array-index').value = i + 1
  })

  //ADD SECTION
  // const addSection = document.querySelectorAll('.add-section')
  const nAddSection = document.createElement('div')
  const newSection = document.createElement('section')
  const nArrayIndex = document.createElement('input')
  const nBackgroundImage = document.createElement('input')
  const nClassInput = document.createElement('input')
  const nContentLang = document.createElement('input')
  const nSectionID = document.createElement('input')
  const newDiv1 = document.createElement('div')
  const newDiv2 = document.createElement('div')
  const editDiv = document.createElement('div')
  nAddSection.classList.add('add-section')
  editDiv.classList.add('edit-section')
  editDiv.dataset.id = ''
  editDiv.innerHTML = document.getElementsByClassName('edit-section')[1].innerHTML
  editDiv.addEventListener('click', function () {
    secOpts(editDiv) //editDiv.querySelector('.edit-background-options')
  }, false)

  document.documentElement.addEventListener('click', function (i) {
    if (editDiv.contains(i.target) !== true) {
      editDiv.classList.remove('jp-open')
      editDiv.classList.remove('theme-background')
      editDiv.classList.remove('secondary-background')
      editDiv.parentNode.style.overflow = 'hidden'
      editDiv.parentNode.style.zIndex = 'auto'
      editDiv.querySelector('.section-menu').classList.remove('show')
      if (editDiv.querySelector('.edit-background-options')) {
        editDiv.querySelector('.edit-background-options').classList.remove('show')
      }
    }
  }, passiveSupported ? {
    passive: true,
    capture: true
  } : true)

  editDiv.getElementsByTagName('a')[0].addEventListener('click', function () {
    toggleBgMenu(editDiv.querySelector('.edit-background-options'))
  }, false)

  const nEditBg = editDiv.querySelector('.edit-background')
  const nThemeBackground = editDiv.querySelector('.theme-background')
  const nSecondaryBackground = editDiv.querySelector('.secondary-background')
  const nWhiteBackground = editDiv.querySelector('.white-background')
  const nBlackBackground = editDiv.querySelector('.black-background')
  const nImageBackground = editDiv.querySelector('.image-background')
  const nTranSwitch = editDiv.querySelector('.translucence-switch')

  const bgLabel1 = editDiv.querySelector('.edit-background-options').getElementsByTagName('label')[0]
  const bgLabel2 = editDiv.querySelector('.edit-background-options').getElementsByTagName('label')[1]
  const bgLabel3 = editDiv.querySelector('.edit-background-options').getElementsByTagName('label')[2]
  const bgLabel4 = editDiv.querySelector('.edit-background-options').getElementsByTagName('label')[3]
  const bgLabel5 = editDiv.querySelector('.edit-background-options').getElementsByTagName('label')[4]

  const newID = sectionsArray.length + 1

  const nDeleteSection = editDiv.querySelector('.delete-section')
  nDeleteSection.id = 'delete-section-' + newID

  nEditBg.id = 'edit-background-' + newID

  nThemeBackground.id = 'theme-background-' + newID
  nThemeBackground.name = 'background-options-' + newID
  nThemeBackground.checked = false

  nSecondaryBackground.id = 'secondary-background-' + newID
  nSecondaryBackground.name = 'background-options-' + newID
  nSecondaryBackground.checked = false

  nWhiteBackground.id = 'white-background-' + newID
  nWhiteBackground.name = 'background-options-' + newID
  nWhiteBackground.checked = true

  nBlackBackground.id = 'black-background-' + newID
  nBlackBackground.name = 'background-options-' + newID
  nBlackBackground.checked = false

  nImageBackground.id = 'image-background-' + newID
  nImageBackground.name = 'background-options-' + newID
  nImageBackground.checked = false

  nTranSwitch.id = 'translucence-switch-' + newID
  nTranSwitch.checked = false

  bgLabel1.setAttribute('for', 'theme-background-' + newID)
  bgLabel2.setAttribute('for', 'secondary-background-' + newID)
  bgLabel3.setAttribute('for', 'white-background-' + newID)
  bgLabel4.setAttribute('for', 'black-background-' + newID)
  bgLabel5.setAttribute('for', 'image-background-' + newID)

  nThemeBackground.addEventListener('click', function () {
    toggleBg(editDiv.parentElement.querySelector('.class'), nThemeBackground, nSecondaryBackground, nWhiteBackground, nBlackBackground, nImageBackground, editDiv)
  }, false)
  nSecondaryBackground.addEventListener('click', function () {
    toggleBg(editDiv.parentElement.querySelector('.class'), nSecondaryBackground, nThemeBackground, nWhiteBackground, nBlackBackground, nImageBackground, editDiv)
  }, false)
  nWhiteBackground.addEventListener('click', function () {
    toggleBg(editDiv.parentElement.querySelector('.class'), nWhiteBackground, nThemeBackground, nSecondaryBackground, nBlackBackground, nImageBackground, editDiv)
  }, false)
  nBlackBackground.addEventListener('click', function () {
    toggleBg(editDiv.parentElement.querySelector('.class'), nBlackBackground, nThemeBackground, nSecondaryBackground, nWhiteBackground, nImageBackground, editDiv)
  }, false)
  nImageBackground.parentElement.querySelector('label').addEventListener('click', function () {
    nImageBackground.checked = true
    toggleBg(editDiv.parentElement.querySelector('.class'), nImageBackground, nThemeBackground, nSecondaryBackground, nWhiteBackground, nImageBackground, editDiv)
    nClassInput.value = nImageBackground.value
    if (imgSaveBtn) imgSaveBtn.dataset.target = editDiv.parentElement.classList[0]
    _body.classList.add('parallax-background-select')
  }, false)

  nArrayIndex.classList.add('array-index')
  nArrayIndex.name = 'array-index[]'
  nArrayIndex.type = 'hidden'
  nArrayIndex.value = ''

  nBackgroundImage.classList.add('background-image')
  nBackgroundImage.name = 'background-image[]'
  nBackgroundImage.type = 'hidden'
  nBackgroundImage.value = ''

  nClassInput.classList.add('class')
  nClassInput.name = 'class[]'
  nClassInput.type = 'hidden'
  nClassInput.value = 'white-background'

  nContentLang.classList.add('content-lang')
  nContentLang.name = 'content-lang[]'
  nContentLang.type = 'hidden'
  nContentLang.value = siteLang

  nSectionID.classList.add('content-id')
  nSectionID.name = 'content-id[]'
  nSectionID.type = 'hidden'
  nSectionID.value = ''

  newSection.classList.add('white-background')
  newSection.classList.add('section-' + newID)
  newSection.classList.add('text')

  newDiv1.classList.add('content')

  newDiv2.classList.add('textarea')
  newDiv2.innerHTML = '<h2>' + headline_str + '</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>'

  newSection.appendChild(newDiv1)
  newSection.appendChild(nArrayIndex)
  newSection.appendChild(nBackgroundImage)
  newSection.appendChild(nClassInput)
  newSection.appendChild(nContentLang)
  newSection.appendChild(nSectionID)
  newSection.appendChild(editDiv)
  newDiv1.appendChild(newDiv2)

  const addSectionArr = Array.prototype.slice.call(document.getElementsByClassName('add-section'))
  addSectionArr.forEach(function (adSec) {
    let responseObject = new Object({})
    adSec.addEventListener('click', function () {
      addSection(adSec, sectionsArray, newSection, nAddSection, addSectionArr, responseObject, nDeleteSection, editDiv, nSectionID, sectionOptions)
      //   const currentOrder = this.dataset.order
      //   tinymce.remove()
      //   sectionsArray.splice(currentOrder, 0, newSection)
      //   let referenceNode = document.querySelector('.section-' + currentOrder)
      //   let requestString = 'new-section&content-lang=' + siteLang + '&array-index=' + currentOrder
      //   nAddSection.dataset.order = this.dataset.order
      //   nAddSection.addEventListener('click', function(){
      //     //
      //   }, false)
      //   addSectionArr.forEach(function(a){
      //     if (parseInt(a.dataset.order) >= parseInt(currentOrder)) {
      //       a.dataset.order = parseInt(a.dataset.order) + 1
      //     }
      //   })
      //   addSectionArr.push(nAddSection)
      //   referenceNode.parentNode.insertBefore(newSection, referenceNode.nextSibling)
      //   referenceNode.parentNode.insertBefore(nAddSection, newSection)
      //   sectionsArray.forEach( function (sec, i) {
      //     sec.querySelector('.array-index').value = i + 1
      //     setTimeout(function() {
      //       sec.querySelector('.textarea').id = 'textarea-' + (i + 1)
      //     }, 100)
      //   })
      //   setTimeout(function() {
      //     tinymce.init(tinySettings)
      //   }, 200)
      //   dbQuery(requestString, '/jp-includes/insert/add-section.php', 'application/x-www-form-urlencoded', messageSuccess, added_str, responseObject).then(function(){
      //     nDeleteSection.addEventListener('click', function () {
      //       deleteSec(editDiv, responseObject.id, currentOrder)
      //     }, false)
      //     setTimeout(function(){
      //       // console.log(responseObject.id)
      //       nSectionID.value = editDiv.dataset.id = responseObject.id
      //     }, 100)
      //   })
      //   sectionOptions.push(newSection)
    })
  })

  //SAVE CHANGES
  document.getElementById('update-frontpage').addEventListener('submit', function (e) {
    let requestString
    let requestArray = new Array([])
    e.preventDefault()
    sectionsArray.forEach(function (sec, i) {
      arrayIndex = sec.querySelector('.array-index').value
      bgImage = sec.querySelector('.background-image').value
      contentClass = sec.querySelector('.class').value
      contentLang = sec.querySelector('.content-lang').value
      sectionID = sec.querySelector('.content-id').value
      sectionText = encodeURIComponent(tinymce.get('textarea-' + (i + 1)).getContent())
      requestString = 'section-text=' + sectionText + '&section-id=' + sectionID + '&content-lang=' + contentLang + '&class=' + contentClass + '&background-image=' + bgImage + '&array-index=' + arrayIndex
      requestArray.push(queryStringToJSON(requestString))
    })
    requestArray.shift()
    dbQuery(encodeURIComponent(JSON.stringify(requestArray)), '/jp-includes/update/update-home.php', 'application/json', messageSuccess, saved_str)
  }, false)

}

//ARTICLES
if (isArticle()) {

  //VARIABLES
  const articleSlug = document.getElementById('article-slug')
  const translatedSlug = document.getElementById('translated-slug')
  const slugOutput = document.getElementById('slug-output')
  const slugHiddenInput = articleSlug.querySelector('input')
  const titleInput = document.getElementById('article-title')
  featuredImageContainer = document.getElementById('featured-image-container')
  let imageMenu
  if (featuredImageContainer) {
    imageInstructions = featuredImageContainer.querySelector('.instructions')
    imageMenu = featuredImageContainer.querySelector('.image-menu')
    initialImagePosition = imagePositionInput.dataset.value
  }
  featuredImageMenu = document.getElementById('edit-featured-image')
  const imagePosition = document.getElementById('image-position')
  imageSaveContainer = document.getElementById('image-buttons')
  const imageSave = document.getElementById('image-save')
  const imageCancel = document.getElementById('image-cancel')

  //SLUG
  let slugInput = document.createElement('input')
  slugInput.value = slugOutput.innerHTML
  const editSlug = articleSlug.querySelector('button')
  editSlug.onclick = function () {
    if (editSlug.classList.contains('edit')) {
      slugInput.parentNode.replaceChild(slugOutput, slugInput)
      editSlug.innerHTML = 'Rediger'
      editSlug.classList.remove('edit')
      articleSlug.classList.add('edited')
    } else {
      slugOutput.parentNode.replaceChild(slugInput, slugOutput)
      editSlug.innerHTML = 'OK'
      editSlug.classList.add('edit')
    }
  }
  slugInput.addEventListener('keyup', function () {
    slugHiddenInput.value = slugOutput.innerHTML = slugInput.value
  }, false)
  if (slugHiddenInput.value === 'new-article') {
    titleInput.addEventListener('keyup', function () {
      slugHiddenInput.value = slugOutput.innerHTML = slugify(titleInput.innerText)
    }, false)
  }

  translatedSlug.addEventListener('keyup', function () {
    setTimeout(function () {
      translatedSlug.value = slugify(translatedSlug.value)
    }, 500)
  }, false)

  //FEATURED IMAGE
  if (featuredImageContainer) {
    featuredImageContainer.addEventListener('click', function () {
      featuredImageContainer.classList.toggle('menu-open')
      document.getElementById('edit-featured-image-button').classList.toggle('theme-background')
      _body.addEventListener('click', function (e) {
        let isClickInside = featuredImageContainer.contains(e.target)
        if (!isClickInside && featuredImageContainer.classList.contains('menu-open')) {
          featuredImageContainer.classList.remove('menu-open')
          document.getElementById('edit-featured-image-button').classList.remove('theme-background')
        }
      }, passiveSupported ? {
        passive: true
      } : false)
    }, false)

    //Featured image position
    imagePosition.addEventListener('click', function () {
      featuredImageContainer.classList.remove('menu-open')
      openDragUI()
    }, false)

    if (imgSaveBtn) imgSaveBtn.addEventListener('click', openDragUI, true)

    // if (displayImage) displayImage.addEventListener('change', e => {
    //   console.log(e.target.checked)
    // })

    imageSave.addEventListener('click', function (e) {
      e.preventDefault()
      document.getElementById('original-featured-image').value = featuredImageInput.value
      featuredImageId.value = featuredImageElement.dataset.id
      closeDragUI()
    }, false)

    imageCancel.addEventListener('click', function (e) {
      e.preventDefault()
      closeDragUI()
      imagePositionInput.dataset.edited = true
      imagePositionInput.value = initialImagePosition
      featuredImageElement.style.transform = 'translateY(' + initialImagePosition + '%)'
      featuredImageElement.style.top = '0'
      featuredImageInput.value = featuredImageElement.src = document.getElementById('original-featured-image').value
    }, false)
  }

  const updateArticle = document.getElementById('update-article')

  //SAVE CHANGES
  updateArticle.addEventListener('submit', function (e) {
    e.preventDefault()
    if (articleSlug.classList.contains('edited')) {
      let result = confirm(youHaveChangedUrl)
      if (!result) {
        return
      }
    }
    const pageId = document.getElementById('page-id').value
    let pageTitle = encodeURIComponent(tinymce.get('article-title').getContent())
    let pageSlug = document.getElementById('slug-output').innerText
    let pageDesc = encodeURIComponent(tinymce.get('article-summary').getContent())
    let pageContent = encodeURIComponent(tinymce.get('article-content').getContent())
    let created = document.getElementById('created').value
    let pageType = document.getElementById('page-type').value
    let featuredImageHeight = ''
    let imagePositionPixel = ''
    let imagePositionPercent = ''
    let imagePosition = ''
    let requestString
    if (featuredImageContainer) {
      featuredImageHeight = featuredImageElement.clientHeight
      imagePositionPixel = imagePositionInput.value
      imagePositionPercent = ((imagePositionPixel / featuredImageHeight) * 100).toFixed(2)
      if (imagePositionInput.dataset.edited === 'true') {
        imagePosition = imagePositionPercent
      } else {
        imagePosition = imagePositionInput.value
      }
      requestString = 'update-article&lang=' + siteLang + '&page-id=' + pageId + '&article-title=' + pageTitle + '&article-label=' + pageLabel.value + '&article-slug=' + pageSlug + '&translated-slug=' + translatedSlug.value + '&article-summary=' + pageDesc + '&article-content=' + pageContent + '&featured-image=' + featuredImageInput.value + '&featured-image-id=' + featuredImageId.value + '&image-position=' + imagePosition + '&created=' + created + '&page-type=' + pageType + '&published=' + published.value + '&display-in-menu=' + displayInMenu.value + '&display-image=' + (displayImage.checked ? 1 : 0)
    } else {
      requestString = 'update-article&lang=' + siteLang + '&page-id=' + pageId + '&article-title=' + pageTitle + '&article-label=' + pageLabel.value + '&article-slug=' + pageSlug + '&translated-slug=' + translatedSlug.value + '&article-summary=' + pageDesc + '&article-content=' + pageContent + '&created=' + created + '&page-type=' + pageType + '&published=' + published.value + '&display-in-menu=' + displayInMenu.value
    }

    dbQuery(requestString, '/jp-includes/update/update-article.php', 'application/x-www-form-urlencoded', messageSuccess, saved_str).then(function () {
      if (articleSlug.classList.contains('edited')) {
        window.location.href = hostName + '/' + pageSlug
      }
    })
  }, false)

  //PUBLISH
  const publishSwitch = document.getElementById('publish')
  const publishLabel = publishSwitch.parentElement.parentElement.getElementsByTagName('label')[0]
  const publishSpan = publishSwitch.parentElement.parentElement.getElementsByTagName('span')[0]
  publishSwitch.addEventListener('change', function () {
    saveArticleDetails.style.opacity = '1'
    saveArticleDetails.style.visibility = 'visible'
    if (publishSwitch.checked) {
      published.value = '1'
      publishLabel.innerText = public_str //'Public'
      publishSpan.innerText = unpublish_str + ':' //'Unpublish:'
    } else {
      published.value = '0'
      publishLabel.innerText = draft_str //'Draft'
      publishSpan.innerText = publish_str + ':' //'Publish:'
    }
  }, false)

  const displayInMenuSwitch = document.getElementById('display-in-menu-switch')
  const displayInMenuSpan = displayInMenuSwitch.parentElement.parentElement.getElementsByTagName('span')[0]
  displayInMenuSwitch.addEventListener('change', function () {
    saveArticleDetails.style.opacity = '1'
    saveArticleDetails.style.visibility = 'visible'
    if (displayInMenuSwitch.checked) {
      displayInMenu.value = 'checked'
      displayInMenuSpan.innerText = hideFromMenu_str + ':'
    } else {
      displayInMenu.value = ''
      displayInMenuSpan.innerText = displayInMenu_str + ':'
    }
  }, false)

  //SAVE ARTICLE DETAILS
  const saveArticleDetails = document.getElementById('save-article-details')
  saveArticleDetails.addEventListener('click', function (e) {
    e.preventDefault()
    document.querySelector('.jp-save-changes').click()
  }, false)

  pageLabel.addEventListener('input', function () {
    saveArticleDetails.style.opacity = '1'
    saveArticleDetails.style.visibility = 'visible'
  }, false)

  changeFunction(imgSaveBtn, 'click', openDragUI, insertImage, _body, 'tinymce-image-module')
}

//SAVE CHANGES SCROLLMENU
const updateScrollMenu = document.getElementById('update-scrollmenu')
if (updateScrollMenu) {
  updateScrollMenu.addEventListener('submit', function (e) {
    e.preventDefault()
    let scrollMenuText = encodeURIComponent(tinymce.get('scroll-menu-text').getContent())
    let requestString = 'update-scrollmenu&lang=' + siteLang + '&scroll-menu-text=' + scrollMenuText

    dbQuery(requestString, '/jp-includes/update/update-scroll-menu.php', 'application/x-www-form-urlencoded', messageSuccess, saved_str)
  }, false)
}

//Edit background footer
const footerOptions = document.getElementById('edit-footer')
const footerClassInput = document.getElementById('footer-class')
const editFooter = document.getElementById('edit-footer')
let footerBgOptions
if (footerOptions) {
  footerBgOptions = footerOptions.querySelector('.edit-background-options')
  footerOptions.addEventListener('click', function () {
    secOpts(footerOptions)
  }, false)
}

//EDIT BACKGROUND
if (editFooter) { //editBg
  const footerThemeBackground = document.getElementById('footer-theme-background') //themeBackground
  const footerSecondaryBackground = document.getElementById('footer-secondary-background') //secondaryBackground
  const footerWhiteBackground = document.getElementById('footer-white-background') //whiteBackground
  const footerBlackBackground = document.getElementById('footer-black-background') //blackBackground
  const footerImageBackground = document.getElementById('footer-image-background') //imageBackground
  const footerTranSwitch = document.getElementById('footer-translucence-switch') //tranSwitch
  document.getElementById('edit-background-footer').addEventListener('click', function () {
    toggleBgMenu(footerBgOptions)
  }, false)
  footerThemeBackground.addEventListener('change', function () {
    toggleBg(footerClassInput, footerThemeBackground, footerSecondaryBackground, footerWhiteBackground, footerBlackBackground, footerImageBackground, footerOptions)
    // console.log(classInput, themeBackground.value, secondaryBackground.value, whiteBackground.value, secOpt)
  }, false)
  footerSecondaryBackground.addEventListener('change', function () {
    toggleBg(footerClassInput, footerSecondaryBackground, footerThemeBackground, footerWhiteBackground, footerBlackBackground, footerImageBackground, footerOptions)
    // console.log(classInput, secondaryBackground.value, themeBackground.value, whiteBackground.value, secOpt)
  }, false)
  footerWhiteBackground.addEventListener('change', function () {
    toggleBg(footerClassInput, footerWhiteBackground, footerThemeBackground, footerSecondaryBackground, footerBlackBackground, footerImageBackground, footerOptions)
    // console.log(classInput, whiteBackground.value, themeBackground.value, secondaryBackground.value, secOpt)
  }, false)
  footerBlackBackground.addEventListener('change', function () {
    toggleBg(footerClassInput, footerBlackBackground, footerThemeBackground, footerSecondaryBackground, footerWhiteBackground, footerImageBackground, footerOptions)
    // console.log(classInput, whiteBackground.value, themeBackground.value, secondaryBackground.value, secOpt)
  }, false)
  footerTranSwitch.addEventListener('change', function () {
    if (this.checked) {
      classInput.value += ' translucent'
      classInput.parentElement.classList.add('translucent')
      // console.log(classInput.value)
    } else {
      footerClassInput.value = footerClassInput.value.replace(' translucent', '')
      footerClassInput.parentElement.classList.remove('translucent')
      // console.log(classInput.value)
    }
  }, false)
  footerImageBackground.parentElement.querySelector('label').addEventListener('click', function () {
    footerImageBackground.checked = true
    toggleBg(footerClassInput, footerImageBackground, footerThemeBackground, footerSecondaryBackground, footerWhiteBackground, footerBlackBackground, footerOptions)
    footerClassInput.value = footerImageBackground.value
    if (imgSaveBtn) imgSaveBtn.dataset.target = footerOptions.parentElement.classList[0]
    _body.classList.add('parallax-background-select')
  }, false)

  //Name colors
  if (isHome() || isArticle() || isSettings()) {
    footerOptions.querySelector('.radio-list').getElementsByTagName('li')[0].querySelector('label').innerText = ntc.name(themeColor)
    footerOptions.querySelector('.radio-list').getElementsByTagName('li')[1].querySelector('label').innerText = ntc.name(secondaryColor)
    footerOptions.querySelector('.radio-list').getElementsByTagName('li')[2].querySelector('label').innerText = ntc.name(whiteColor)
  }
}

//SAVE CHANGES FOOTER
const updateFooter = document.getElementById('update-footer')

if (updateFooter) {
  updateFooter.addEventListener('submit', function (e) {
    e.preventDefault()
    const footerOne = encodeURIComponent(tinymce.get('footer-1').getContent())
    const footerTwo = encodeURIComponent(tinymce.get('footer-2').getContent())
    const footerThree = encodeURIComponent(tinymce.get('footer-3').getContent())
    const footerClass = document.getElementById('footer-class').value
    const footerBackgroundImageId = document.getElementById('footer-background-image-id').value
    const footerBackgroundImage = document.getElementById('footer-background-image').value
    const requestString = 'update-footer&lang=' + siteLang + '&column-one=' + footerOne + '&column-two=' + footerTwo + '&column-three=' + footerThree + '&footer-class=' + footerClass + '&footer-background-image-id=' + footerBackgroundImageId + '&footer-background-image=' + footerBackgroundImage

    dbQuery(requestString, '/jp-includes/update/update-footer.php', 'application/x-www-form-urlencoded', messageSuccess, saved_str)
  }, false)
}

//GOOGLE MAPS
const gmf = document.getElementById('googlemaps-form')
const gmfAltLang = document.getElementById('googlemaps-form-alt-lang')
const gmfAddWaypt = document.getElementById('googlemaps-add-waypoint')
const gmfAddWayptAltLang = document.getElementById('googlemaps-add-waypoint-alt-lang')
const gfmWrapper = document.getElementById('gfm-main-wrapper')
const gfmAltWrapper = document.getElementById('gfm-alt-wrapper')
const chooseLanguage = document.getElementById('choose-language')
const langSwitch = document.getElementById('language-switch')

let wayptGroupAltLang
let wayptOrder
let wayptLabel
let wayptDesc
let wayptLng
let wayptLat
let wayptImg
let wayptId

//THUMBNAILIFY | GOOGLE MAPS
function thumbify(str) {
  str = str.replace('/uploads/', '/uploads/thumbnails/')
  str = str.replace('.jpg', '-thumbnail.jpg')
  return str
}

//CHOOSE IMAGE | GOOGLE MAPS
const wayptImgLinks = document.getElementsByClassName('choose-waypoint-image')
if (wayptImgLinks.length > 0) {
  Array.prototype.slice.call(wayptImgLinks).forEach(function (link) {
    let input = link.parentElement.querySelector('input')
    link.addEventListener('click', function () {
      if (imgSaveBtn) {
        imgSaveBtn.onclick = function () {
          link.querySelector('img').src = input.value = thumbify(selectedMedia.querySelector('img').src)
          document.getElementById('update-googlemaps').classList.add('show')
          gmfAddWaypt.classList.add('hide')
          if (gmfAltLang) {
            document.getElementById('update-googlemaps-alt-lang').classList.add('show')
            gmfAddWayptAltLang.classList.add('hide')
          }
        }
      }
    }, false)
  })
}

if (gmf) {
  _body.style.minHeight = gfmWrapper.offsetHeight + gfmWrapper.offsetTop + 101 + 'px'
  const wayptGroup = gmf.querySelectorAll('.waypoint-group')
  gmf.querySelectorAll('input, textarea').forEach(function (input) {
    input.addEventListener('input', function () {
      document.getElementById('update-googlemaps').classList.add('show')
      gmfAddWaypt.classList.add('hide')
      if (gmfAltLang) {
        chooseLanguage.getElementsByTagName('p')[0].style.visibility = 'visible'
        chooseLanguage.getElementsByTagName('p')[0].style.opacity = '1'
      }
    }, false)
  })
  if (gmfAltLang) {
    wayptGroupAltLang = gmfAltLang.querySelectorAll('.waypoint-group')
    gmfAltLang.querySelectorAll('input, textarea').forEach(function (input) {
      input.addEventListener('input', function () {
        document.getElementById('update-googlemaps-alt-lang').classList.add('show')
        gmfAddWayptAltLang.classList.add('hide')
        chooseLanguage.getElementsByTagName('p')[0].style.visibility = 'visible'
        chooseLanguage.getElementsByTagName('p')[0].style.opacity = '1'
      }, false)
    })
  }

  gmf.addEventListener('submit', function (e) {
    e.preventDefault()
    let requestString
    let requestArray = new Array([])
    wayptGroup.forEach(function (waypt) {
      wayptOrder = waypt.querySelector('.waypoint-order').value
      wayptLabel = waypt.querySelector('.waypoint-label').value
      wayptDesc = waypt.querySelector('.waypoint-description').value
      wayptLng = waypt.querySelector('.waypoint-longitude').value
      wayptLat = waypt.querySelector('.waypoint-latitude').value
      wayptImg = waypt.querySelector('.waypoint-image').value
      wayptId = waypt.querySelector('.waypoint-id').value
      requestString = 'label=' + wayptLabel + '&description=' + wayptDesc + '&latitude=' + wayptLat + '&longitude=' + wayptLng + '&image=' + wayptImg + '&order=' + wayptOrder + '&id=' + wayptId
      requestArray.push(queryStringToJSON(requestString))
    })
    requestArray.shift()
    dbQuery(encodeURIComponent(JSON.stringify(requestArray)), '/plugins/googlemaps/inc/update-googlemaps.php', 'application/json', messageSuccess, saved_str)
  }, false)

  if (gmfAltLang) {
    gmfAltLang.addEventListener('submit', function (e) {
      e.preventDefault()
      let requestString
      let requestArray = new Array([])
      wayptGroupAltLang.forEach(function (waypt) {
        wayptOrder = waypt.querySelector('.waypoint-order').value
        wayptLabel = waypt.querySelector('.waypoint-label').value
        wayptDesc = waypt.querySelector('.waypoint-description').value
        wayptLng = waypt.querySelector('.waypoint-longitude').value
        wayptLat = waypt.querySelector('.waypoint-latitude').value
        wayptImg = waypt.querySelector('.waypoint-image').value
        wayptId = waypt.querySelector('.waypoint-id').value
        requestString = 'label=' + wayptLabel + '&description=' + wayptDesc + '&latitude=' + wayptLat + '&longitude=' + wayptLng + '&image=' + wayptImg + '&order=' + wayptOrder + '&id=' + wayptId
        requestArray.push(queryStringToJSON(requestString))
      })
      requestArray.shift()
      dbQuery(encodeURIComponent(JSON.stringify(requestArray)), '/plugins/googlemaps/inc/update-googlemaps.php', 'application/json', messageSuccess, saved_str)
    }, false)
  }
}

//LANG SWITCH | GOOGLE MAPS
if (langSwitch) {
  const labelEn = chooseLanguage.querySelector('label')
  const labelNo = chooseLanguage.getElementsByTagName('label')[2]
  langSwitch.addEventListener('change', function () {
    labelEn.classList.toggle('current')
    labelNo.classList.toggle('current')
    gfmWrapper.classList.toggle('hide')
    gfmAltWrapper.classList.toggle('hide')
  }, false)
}

const phpinfoLink = document.getElementById('phpinfo')
if (phpinfoLink) {
  phpinfoLink.addEventListener('click', function (e) {
    e.preventDefault()
    popUpWindow(phpinfoLink, phpinfoLink.href, '1000')
  }, false)
}

function tinyCloseModule() {
  if (_module.querySelector('.module-inner').contains(event.target) === false) {
    closeModule()
    window.removeEventListener('click', tinyCloseModule, true)
  }
}

function hasError(el) {
  el.classList.add('has-error')
  setTimeout(function () {
    el.classList.remove('has-error')
  }, 1500)
}

//ADD USER
const newUserForm = document.getElementById('add-user-form')
if (newUserForm) {
  const nUsername = document.getElementById('username')
  const nEmail = document.getElementById('email')
  const nPassword = document.getElementById('password')
  const nConfirmPassword = document.getElementById('confirm_password')
  const nRole = document.getElementById('user-role')
  const _input = Array.prototype.slice.call(document.getElementsByTagName('input'))
  newUserForm.addEventListener('submit', function (e) {
    e.preventDefault()
    for (let i = 0 i < _input.length i++) {
      if (!_input[i].value) {
        hasError(_input[i].parentElement)
        return
      }
    }
    if (nPassword.value !== nConfirmPassword.value) {
      nConfirmPassword.parentElement.classList.add('has-error')
      nConfirmPassword.parentElement.querySelector('.help-block').innerText = pwdNoMatch_str
      setTimeout(function () {
        nConfirmPassword.parentElement.classList.remove('has-error')
      }, 1500)
      return
    }
    const requestString = 'add-user&username=' + nUsername.value + '&email=' + nEmail.value + '&password=' + nPassword.value + '&confirm_password=' + nConfirmPassword.value + '&user_role=' + nRole.value
    dbQuery(requestString, '/jp-includes/insert/add-user.php', 'application/x-www-form-urlencoded', messageSuccess, newUser_str, false, '/jp-admin/users.php?newuser=success')
  })
}

//EXPORT EXCEL
function download_csv(csv, filename) {
  var csvFile
  var downloadLink

  csvFile = new Blob([csv], { type: "text/csv" })
  downloadLink = document.createElement("a")
  downloadLink.download = filename
  downloadLink.href = window.URL.createObjectURL(csvFile)
  downloadLink.style.display = "none"
  document.body.appendChild(downloadLink)
  downloadLink.click()
}

function export_table_to_csv(html, filename) {
  var csv = []
  var rows = document.querySelectorAll("table tr")
  for (var i = 0 i < rows.length i++) {
    var row = [], cols = rows[i].querySelectorAll("td, th")
    for (var j = 0 j < cols.length j++)
      row.push(cols[j].innerText)
    csv.push(row.join(","))
  }

  download_csv(csv.join("\n"), filename)
}

if (document.getElementsByClassName('results-page').length > 0) {
  document.getElementById('btnExport').addEventListener('click', function () {
    var html = document.querySelector('table').outerHTML
    export_table_to_csv(html, 'resultater.csv')
  })
}

if (document.getElementById('embed-youtube')) {
  document.getElementById('embed-youtube').querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault()
    let videoSize
    Array.prototype.slice.call(document.getElementsByName('yt-size')).forEach(function (size) {
      if (size.checked) {
        videoSize = size.value
      }
    })
    insertVideo(document.getElementById('youtube-url').value, document.getElementById('youtube-title').value, videoSize)
  }, false)
}

function insertVideo(_url, title, size) {
  const ytID = getLastItem(_url)
  const ytHTML = '<p><span class="video-iframe ' + size + '-video"><iframe title="' + title + '" src="https://www.youtube.com/embed/' + ytID.replace('watch?v=', '') + '?html5=1" width="510" height="608" frameborder="0" sandbox="allow-scripts allow-same-origin" allowfullscreen=""></iframe></span></p>'
  tinymce.activeEditor.insertContent(ytHTML)
  closeYTE()
}

Array.prototype.slice.call(document.getElementsByClassName('video-iframe')).forEach(function (v) {
  v.contentEditable = false
  v.style.backgroundImage = 'url(\'https://i.ytimg.com/vi/' + v.querySelector('iframe').src.replace('?html5=1', '').replace('https://www.youtube.com/embed/', '') + '/sddefault.jpg\')'
})

const getLastItem = thePath => thePath.substring(thePath.lastIndexOf('/') + 1)

//GET AVERAGE COLOR FROM IMAGE
function getAverageRGB(imgEl) {
  // if (imgEl.src.indexOf('.svg') > -1) {
  //   let rgb = {r:255,g:0,b:0}
  //   return rgb
  // }
  const blockSize = 5 // only visit every 5 pixels
  const defaultRGB = { r: 127, g: 127, b: 127 } // for non-supporting envs
  const canvas = document.createElement('canvas')
  const context = canvas.getContext && canvas.getContext('2d')
  let data
  let width
  let height
  let i = -4
  let length
  let rgb = { r: 0, g: 0, b: 0 }
  let count = 0

  if (!context) {
    return defaultRGB
  }

  height = canvas.height = imgEl.naturalHeight || imgEl.offsetHeight || imgEl.height
  width = canvas.width = imgEl.naturalWidth || imgEl.offsetWidth || imgEl.width

  context.drawImage(imgEl, 0, 0)

  try {
    data = context.getImageData(0, 0, width, height)
  } catch (e) {
    /* security error, img on diff domain */
    return defaultRGB
  }

  length = data.data.length

  while ((i += blockSize * 4) < length) {
    ++count
    rgb.r += data.data[i]
    rgb.g += data.data[i + 1]
    rgb.b += data.data[i + 2]
  }

  // ~~ used to floor values
  rgb.r = ~~(rgb.r / count)
  rgb.g = ~~(rgb.g / count)
  rgb.b = ~~(rgb.b / count)

  return rgb
}

//Custom select
function closeAllSelect(el) {
  var x, y, i, arrNo = []
  x = document.getElementsByClassName('select-items')
  y = document.getElementsByClassName('select-selected')
  for (i = 0; i < y.length; i++) {
    if (el == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove('select-arrow-active')
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add('select-hide')
    }
  }
}

if (document.getElementsByClassName('custom-select').length > 0) {
  Array.prototype.slice.call(document.getElementsByClassName('custom-select')).forEach(function (el) {
    const selEl = el.getElementsByTagName('select')[0]
    const cSel = document.createElement('DIV')
    cSel.classList.add('select-selected')
    cSel.classList.add('noselect')
    cSel.innerHTML = selEl.options[selEl.selectedIndex].innerHTML
    el.appendChild(cSel)
    const cSelLi = document.createElement('DIV')
    cSelLi.classList.add('select-items')
    cSelLi.classList.add('select-hide')
    cSelLi.classList.add('secondary-background')
    for (let i = 0; i < selEl.length; i++) {
      const cSelOpt = document.createElement('DIV')
      cSelOpt.innerHTML = selEl.options[i].innerHTML
      cSelOpt.addEventListener('click', function () {
        let parentSelect, prev, same
        parentSelect = this.parentElement.parentElement.getElementsByTagName('select')[0]
        prev = this.parentElement.previousSibling
        for (let i = 0 i < parentSelect.length i++) {
          if (parentSelect.options[i].innerHTML === this.innerHTML) {
            parentSelect.selectedIndex = i
            prev.innerHTML = this.innerHTML
            same = this.parentNode.getElementsByClassName('same-as-selected')
            Array.prototype.slice.call(same).forEach(function (s) {
              s.classList.remove('same-as-selected')
            })
            this.classList.add('same-as-selected')
            break
          }
        }
        prev.click()
      }, false)
      cSelLi.appendChild(cSelOpt)
    }
    el.appendChild(cSelLi)
    cSel.addEventListener('click', function (e) {
      if (e.stopPropagation()) {
        e.stopPropagation()
      } else {
        e.cancelBubble = true
      }
      closeAllSelect(this)
      this.nextSibling.classList.toggle('select-hide')
      this.classList.toggle('select-open')
    }, false)
  })

  document.addEventListener('click', function (e) {
    if (e.target.nodeName.toLowerCase() !== 'select') {
      Array.prototype.slice.call(document.getElementsByClassName('select-open')).forEach(function (sel) {
        sel.classList.remove('select-open')
      })
      closeAllSelect()
    }
  }, false)
}
