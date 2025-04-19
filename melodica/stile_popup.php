<style>
    #popup {
        display: none;
        position: fixed;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        background: #6b47a1;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 1000;
    }
    #popup.hidden { display: none; }
    .popup-content {
      background: white;
      font-family: Arial, sans-serif;
      padding: 20px;
      border-radius: 8px;
      text-align: left;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .popup-content p {
      margin: 0 0 8px;
      font-size: 17px;
    }
    .popup-close {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .popup-close button {
      font-size: 20px;
      padding: 1px 7px;
      background-color: #6b47a1;
      color: white;
      border: none;
      border-radius: 900px;
      cursor: pointer;
    }
    .popup-close button:hover {
      background-color: #5a3a85;
    }

    #brano {
      width: 800px; /* Larghezza del player */
      border-radius: 10px;
      max-width: 100%;
    }
</style>
